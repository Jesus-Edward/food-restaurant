<?php

namespace App\Http\Controllers\Frontend;

use App\Events\OrderPaymentUpdateEvent;
use App\Events\OrderPlacedNotificationEvent;
use App\Events\RTOrderPlacedNotificationEvent;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\AllOrdersService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Stripe;
use Stripe\Checkout\Session as  StripeSession;
use Razorpay\Api\Api as RazorpayApi;

class AllPaymentsController extends Controller
{
    function index()
    {
        if (!session()->has('delivery_fee') || !session()->has('address')) {
            throw ValidationException::withMessages(['Something went wrong']);
        }

        $subtotal = cartTotalPrice();
        $delivery = session()->get('delivery_fee') ?? 0;
        $discount = session()->get('coupon')['discount'] ?? 0;
        $grandTotal = grandCartTotal($delivery);
        return view('frontend.pages.payment', compact(
            'subtotal',
            'delivery',
            'discount',
            'grandTotal'
        ));
    }

    function paymentSuccess(): View
    {
        return view('frontend.pages.payment-success');
    }

    function paymentFailure(): View
    {
        return view('frontend.pages.payment-failure');
    }

    function makePayment(Request $request, AllOrdersService $allOrdersService)
    {
        $request->validate([
            'payment_path' => ['required', 'string', 'in:paypal,stripe,razorpay']
        ]);

        /**Create Orders */
        if ($allOrdersService->createAllOrders()) {
            /**Redirect user to the payment host */
            switch ($request->payment_path) {
                case 'paypal':
                    return response(['redirect_url' => route('paypal.payments')]);
                    break;

                case 'stripe':
                    return response(['redirect_url' => route('stripe.payments')]);
                    break;

                    case 'razorpay':
                        return response(['redirect_url' => route('razorpay-redirect')]);
                        break;

                default:
                    break;
            }
        }
    }

    /**Paypal configuration to over ride the default
     * configuration by the laravel paypal package
     */
    function setPaypalConfig(): array
    {

        $config = [
            'mode'    => config('pathwaySettings.paypal_acct_mode'), // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
            'sandbox' => [
                'client_id'         => config('pathwaySettings.paypal_client_id'),
                'client_secret'     => config('pathwaySettings.paypal_secret_key'),
                'app_id'            => 'APP-80W284485P519543T',
            ],
            'live' => [
                'client_id'         => config('pathwaySettings.paypal_client_id'),
                'client_secret'     => config('pathwaySettings.paypal_secret_key'),
                'app_id'            => config('pathwaySettings.paypal_app_id'),
            ],

            'payment_action' =>  'Sale', // Can only be 'Sale', 'Authorization' or 'Order'
            'currency'       => config('pathwaySettings.paypal_currency_name'),
            'notify_url'     => env('PAYPAL_NOTIFY_URL', ''), // Change this accordingly for your application.
            'locale'         => 'en_US', // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
            'validate_ssl'   => true, // Validate SSL when creating api client.
        ];

        return $config;
    }

    /**Paypal payment */
    function payWithPaypal()
    {
        $config = $this->setPaypalConfig();
        $provider = new PayPalClient($config);
        $provider->getAccessToken();

        /**Calculate payable amount */
        $grand_total = session()->get('grandTotal');
        $payableAmount = round($grand_total * config('pathwaySettings.paypal_currency_rate'));

        $response = $provider->createOrder([
            'intent' => "CAPTURE",
            'application_context' => [
                'return_url' => route('paypal.success'),
                'cancel_url' => route('paypal.cancel')
            ],
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => config('pathwaySettings.paypal_currency_name'),
                        'value' => $payableAmount
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != NULL) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        } else {
            return redirect()->route('payment.failure')->withErrors([
                'error' => $response['error']['message']
            ]);
        }
    }

    function paypalSuccess(Request $request, AllOrdersService $allOrdersService)
    {
        $config = $this->setPaypalConfig();
        $provider = new PayPalClient($config);
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->token);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            $orderId = session()->get('order_id');

            $capture = $response['purchase_units'][0]['payments']['captures'][0];
            $paymentInfo = [
                'transaction_id' =>  $capture['id'],
                'currency' => $capture['amount']['currency_code'],
                'status' => 'completed',
            ];

            OrderPaymentUpdateEvent::dispatch($orderId, $paymentInfo, 'PayPal');
            OrderPlacedNotificationEvent::dispatch($orderId);
            RTOrderPlacedNotificationEvent::dispatch(Order::find($orderId));


            /**Clear session after success: This can be done in two way
             * first either by creating an instance of the parent class
             * or through dependency injection.
             */
            // $clearSession = new AllOrdersService();
            // $clearSession->clearSessionItems();

            $allOrdersService->clearSessionItems();

            return redirect()->route('payment.success');
        } else {
            $this->transactionFailedUpdateStatus('Paypal');

            return redirect()->route('payment.failure')->withErrors([
                'error' => $response['error']['message']
            ]);
        }
    }

    function paypalCancel()
    {
        $this->transactionFailedUpdateStatus('Paypal');
        return redirect()->route('payment.failure');
    }

    /**Stripe payment */
    function payWithStripe()
    {
        Stripe::setApiKey(config('pathwaySettings.stripe_secret_key'));

        /**Calculate payable amount */
        $grand_total = session()->get('grandTotal');
        $payableAmount = round($grand_total * config('pathwaySettings.stripe_currency_rate')) * 100;

        $response = StripeSession::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => config('pathwaySettings.stripe_currency_name'),
                        'product_data' => [
                            'name' => 'Product'
                        ],
                        'unit_amount' => $payableAmount
                    ],
                    'quantity' => 1
                ]
            ],
            'mode' => 'payment',
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('stripe.cancel')
        ]);

        return redirect()->away($response->url);
    }

    function stripeSuccess(Request $request, AllOrdersService $allOrdersService)
    {
        $session_id = $request->session_id;
        Stripe::setApiKey(config('pathwaySettings.stripe_secret_key'));
        $response = StripeSession::retrieve($session_id);

        if ($response->payment_status === 'paid') {
            $orderId = session()->get('order_id');

            $paymentInfo = [
                'transaction_id' => $response->payment_intent,
                'currency' => $response->currency,
                'status' => 'completed'
            ];

            OrderPaymentUpdateEvent::dispatch($orderId, $paymentInfo, 'Stripe');
            OrderPlacedNotificationEvent::dispatch($orderId);
            RTOrderPlacedNotificationEvent::dispatch(Order::find($orderId));

            /**Clear session after success: This can be done in two way
             * first either by creating an instance of the parent class
             * or through dependency injection.
             */
            // $clearSession = new AllOrdersService();
            // $clearSession->clearSessionItems();

            $allOrdersService->clearSessionItems();

            return redirect()->route('payment.success');
        } else {

            $this->transactionFailedUpdateStatus('Stripe');

            return redirect()->route('payment.failure');
        }
    }

    function stripeCancel()
    {
        $this->transactionFailedUpdateStatus('Stripe');
        return redirect()->route('payment.failure');
    }

    function razorpayRedirect()
    {
        return view('frontend.pages.razorpay-redirect');
    }

    function payWithRazorpay(Request $request, AllOrdersService $allOrdersService)
    {
        $razorpayApi = new RazorpayApi(
            config('pathwaySettings.razorpay_client_id'),
            config('pathwaySettings.razorpay_secret_key'),
        );

        if ($request->has('razorpay_payment_id') && $request->filled('razorpay_payment_id')) {

            $grandTotal =session()->get('grandTotal');
            $payableAmount = ($grandTotal * config('pathwaySettings.razorpay_currency_rate')) * 100;

            try {
                $response = $razorpayApi->payment
                ->fetch($request->razorpay_payment_id)
                ->capture(['amount' => $payableAmount]);
            } catch (\Exception $e) {
                logger($e);
                $this->transactionFailedUpdateStatus('Razorpay');
                return redirect()->route('payment.failure')->withErrors($e->getMessage());
            }

            if ($response['status'] === 'captured') {
                $orderId = session()->get('order_id');

                $paymentInfo = [
                    'transaction_id' => $response->id,
                    'currency' => config('settings.site_default_currency'),
                    'status' => 'completed'
                ];

                OrderPaymentUpdateEvent::dispatch($orderId, $paymentInfo, 'Razorpay');
                OrderPlacedNotificationEvent::dispatch($orderId);
                RTOrderPlacedNotificationEvent::dispatch(Order::find($orderId));


                /**Clear session after success: This can be done in two way
                 * first either by creating an instance of the parent class
                 * or through dependency injection.
                 */
                // $clearSession = new AllOrdersService();
                // $clearSession->clearSessionItems();

                $allOrdersService->clearSessionItems();

                return redirect()->route('payment.success');
            }else{
                $this->transactionFailedUpdateStatus('Razorpay');
                return redirect()->route('payment.failure');
            }
        }
    }

    function transactionFailedUpdateStatus($pathwayName): void
    {
        $orderId = session()->get('order_id');

        $paymentInfo = [
            'transaction_id' => '',
            'currency' => '',
            'status' => 'FAILED'
        ];

        OrderPaymentUpdateEvent::dispatch($orderId, $paymentInfo, $pathwayName);
    }
}
