<?php

use App\Events\RTOrderPlacedNotificationEvent;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Frontend\AllPaymentsController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\ChatController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\CustomPageController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Models\Order;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'guest'],function(){
    Route::get('default/login/admin', [AdminAuthController::class, 'index'])->name('admin.dashboard');
    Route::get('admin/forget-password', [AdminAuthController::class, 'forgetPassword'])->name('admin.forget-password');

});

Route::group(['middleware' => 'auth', 'verified'], function() {
    Route::get('/dashboard', [DashboardController::class, 'userDashboard'])->name('dashboard');
    Route::put('/edit-profile', [ProfileController::class, 'updateProfile'])->name('user.update.profile');
    Route::put('/change-password', [ProfileController::class, 'updatePassword'])->name('user.update.password');
    Route::post('/change-avatar', [ProfileController::class, 'updateAvatar'])->name('user.update.avatar');
    Route::post('profile/address', [DashboardController::class, 'createAddress'])->name('profile.address.store');
    Route::put('profile/address/{id}/edit', [DashboardController::class, 'updateAddress'])->name('profile.address.edit');
    Route::delete('profile/address/{id}/delete', [DashboardController::class, 'deleteAddress'])->name('profile.address.delete');

    /**Chat routes */
    Route::post('/chat/send-message/', [ChatController::class, 'sendMessage'])->name('chat.send-message');
    Route::get('/chat/get-message/{senderId}', [ChatController::class, 'getMessage'])->name('chat.get-message');
});

/**Show home page route */
Route::get('/', [FrontendController::class, 'index'])->name('home');

/**Chef Page */
Route::get('chef', [FrontendController::class, 'chef'])->name('chef');

/**Testimonial Page */
Route::get('testimonials', [FrontendController::class, 'testimonial'])->name('testimonial');

/**Blogs Route */
Route::get('blogs', [FrontendController::class, 'blogs'])->name('blogs');
Route::get('blogs/{slug}', [FrontendController::class, 'blogDetails'])->name('blogs.details');

/** Route to show product's details */
Route::get('/product/{slug}', [FrontendController::class, 'showProduct'])->name('product.show');

/** Route to show product */
Route::get('/products/', [FrontendController::class, 'productIndex'])->name('product.index');

/**About Page Route */
Route::get('about-page', [FrontendController::class, 'aboutPage'])->name('about-page');

/**Privacy Policy Route */
Route::get('privacy-policy', [FrontendController::class, 'privatePolicy'])->name('privacy-policy');

/**Terms & Conditions Route */
Route::get('terms&cons', [FrontendController::class, 'termsAndCons'])->name('terms&cons');

/**Contact Route */
Route::get('contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('contact', [FrontendController::class, 'sendContactMessage'])->name('contact-send-message');

/**Reservation store route */
Route::post('reservation', [FrontendController::class, 'reservation'])->name('reservation.store');

/**Newsletter Route */
Route::post('subscribe-newsletter', [FrontendController::class, 'subscribeNewsletter'])->name('subscribe-newsletter');

/**Custom Page Route
 * This is an Invoke controller that only has one method
*/
Route::get('page/{slug}', CustomPageController::class);

/**Product modal route */
Route::get('/product-modal/{productId}', [FrontendController::class, 'loadProductModal'])->name('product.modal');
Route::post('product-review', [FrontendController::class, 'productReviewStore'])->name('product-review.store');
Route::get('review-get', [FrontendController::class, 'loadMoreReview'])->name('review.load-more');

//Add to cart route
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add-to-cart');
Route::get('/get-cart-products', [CartController::class, 'getCartProduct'])->name('get-cart-product');
Route::get('cart-product-remove/{rowId}', [CartController::class, 'cartProductRemove'])->name('cart-product-remove');

/**Wishlist Route */
Route::get('wishlist/{productId}', [WishlistController::class, 'storeWishlist'])->name('wishlist.store');

// Cart view route
Route::get('/product/view/cart', [CartController::class, 'viewCart'])->name('product.view.cart');
Route::post('/product/update/cart-qty', [CartController::class, 'updateCartQty'])->name('product.update.cart-qty');
Route::get('/product/cart/destroy', [CartController::class, 'destroyCart'])->name('product.destroy.cart');

/**Coupon route */
Route::post('/apply-coupon', [FrontendController::class, 'applyCoupon'])->name('apply-coupon');
/**destroy coupon route */
Route::get('/destroy-coupon', [FrontendController::class, 'destroyCoupon'])->name('destroy-coupon');

Route::group(['middleware' => 'auth'], function(){
    /**Checkout route */
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::get('/checkout/{id}/delivery-cal', [CheckoutController::class, 'calculateDeliveryCharge'])->name('checkout.delivery-cal');
    Route::post('/checkout/payment', [CheckoutController::class, 'checkoutRedirectPayment'])->name('checkout.payment');

    /**Payment route */
    Route::get('/checkout/payment/index', [AllPaymentsController::class, 'index'])->name('checkout.payment.index');
    Route::post('/make-payment', [AllPaymentsController::class, 'makePayment'])->name('make-payment');

    Route::get('payment-success', [AllPaymentsController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('payment-failure', [AllPaymentsController::class, 'paymentFailure'])->name('payment.failure');

    /**Paypal payment routes */
    Route::get('paypal/payments', [AllPaymentsController::class, 'payWithPaypal'])->name('paypal.payments');
    Route::get('paypal/success', [AllPaymentsController::class, 'paypalSuccess'])->name('paypal.success');
    Route::get('paypal/cancel', [AllPaymentsController::class, 'paypalCancel'])->name('paypal.cancel');

    /**Stripe payment routes */
    Route::get('stripe/payments', [AllPaymentsController::class, 'payWithStripe'])->name('stripe.payments');
    Route::get('stripe/success', [AllPaymentsController::class, 'stripeSuccess'])->name('stripe.success');
    Route::get('stripe/cancel', [AllPaymentsController::class, 'stripeCancel'])->name('stripe.cancel');

    /**Razorpay routes */
    Route::get('razorpay-redirect', [AllPaymentsController::class, 'razorpayRedirect'])->name('razorpay-redirect');
    Route::post('razorpay/payments', [AllPaymentsController::class, 'payWithRazorpay'])->name('razorpay.payments');

    /**Blogs Comment Route */
    Route::post('blogs/comment/{blog_id}', [FrontendController::class, 'blogCommentsStore'])->name('blogs.comments.store');

});

require __DIR__ . '/auth.php';

