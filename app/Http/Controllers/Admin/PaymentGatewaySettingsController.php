<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGatewaySettings;
use App\Services\OrderService;
use App\Services\paymentGatewaySettingService;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class PaymentGatewaySettingsController extends Controller
{
    use FileUploadTrait;

    function index()
    {
        $paymentGateway = PaymentGatewaySettings::pluck('value', 'key');
        return view('admin.payment-settings.index', compact('paymentGateway'));
    }

    function paypalSettingUpdate(Request $request)
    {
        $validatedData = $request->validate([
            "paypal_status" => ['required', 'boolean'],
            "paypal_acct_mode" => ['required', 'in:sandbox,live'],
            "paypal_country_name" => ['required'],
            "paypal_currency_name" => ['required', 'string'],
            "paypal_currency_rate" => ['required', 'numeric'],
            "paypal_client_id" => ['required'],
            "paypal_secret_key" => ['required'],
            "paypal_app_id" => ['required'],
        ]);

        if ($request->hasFile('paypal_logo')) {
            $request->validate([
                "paypal_logo" => ['nullable', 'image']
            ]);

            $imagePath = $this->uploadImage($request, 'paypal_logo');
            PaymentGatewaySettings::updateOrCreate(
                ['key' => 'paypal_logo'],
                ['value' => $imagePath]
            );
        }

        foreach ($validatedData as $key => $value) {
            PaymentGatewaySettings::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $paymentGatewaySettingService = app(paymentGatewaySettingService::class);
        $paymentGatewaySettingService->clearCachedSettings();

        toastr()->success('Done');
        return redirect()->back();
    }

    function stripeSettingUpdate(Request $request)
    {
        $validatedData = $request->validate([
            "stripe_status" => ['required', 'boolean'],
            "stripe_country_name" => ['required'],
            "stripe_currency_name" => ['required', 'string'],
            "stripe_currency_rate" => ['required', 'numeric'],
            "stripe_client_id" => ['required'],
            "stripe_secret_key" => ['required'],
        ]);

        if ($request->hasFile('stripe_logo')) {
            $request->validate([
                "stripe_logo" => ['nullable', 'image']
            ]);

            $imagePath = $this->uploadImage($request, 'stripe_logo');
            PaymentGatewaySettings::updateOrCreate(
                ['key' => 'stripe_logo'],
                ['value' => $imagePath]
            );
        }

        foreach ($validatedData as $key => $value) {
            PaymentGatewaySettings::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $paymentGatewaySettingService = app(paymentGatewaySettingService::class);
        $paymentGatewaySettingService->clearCachedSettings();

        toastr()->success('Done');
        return redirect()->back();
    }

    function razorpaySettingUpdate(Request $request)
    {
        $validatedData = $request->validate([
            "razorpay_status" => ['required', 'boolean'],
            "razorpay_country_name" => ['required'],
            "razorpay_currency_name" => ['required', 'string'],
            "razorpay_currency_rate" => ['required', 'numeric'],
            "razorpay_client_id" => ['required'],
            "razorpay_secret_key" => ['required'],
        ]);

        if ($request->hasFile('razorpay_logo')) {
            $request->validate([
                "razorpay_logo" => ['nullable', 'image']
            ]);

            $imagePath = $this->uploadImage($request, 'razorpay_logo');
            PaymentGatewaySettings::updateOrCreate(
                ['key' => 'razorpay_logo'],
                ['value' => $imagePath]
            );
        }

        foreach ($validatedData as $key => $value) {
            PaymentGatewaySettings::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $paymentGatewaySettingService = app(paymentGatewaySettingService::class);
        $paymentGatewaySettingService->clearCachedSettings();

        toastr()->success('Done');
        return redirect()->back();
    }
}
