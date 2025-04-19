<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\Admin\AppDownloadController;
use App\Http\Controllers\Admin\BannerSliderController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\ChefTeamController;
use App\Http\Controllers\Admin\ClearDatabaseController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CounterController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomPageBuilderController;
use App\Http\Controllers\Admin\DailyOfferController;
use App\Http\Controllers\Admin\DeliveryAreaController;
use App\Http\Controllers\Admin\FooterController;
use App\Http\Controllers\Admin\GeneralSettingsController;
use App\Http\Controllers\Admin\MenuBuilderController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\PaymentGatewaySettingsController;
use App\Http\Controllers\Admin\PrivacyPolicyController;
use App\Http\Controllers\Admin\ProductController; 
use App\Http\Controllers\Admin\ProductGalleryController;
use App\Http\Controllers\Admin\ProductOptionController;
use App\Http\Controllers\Admin\ProductReviewController;
use App\Http\Controllers\Admin\ProductSizeController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\ReservationTimeController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SocialLinksController;
use App\Http\Controllers\Admin\TermsAndConditionController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\WhyChooseUsController;
use Illuminate\Support\Facades\Route;
use Stripe\Tax\Settings;

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    /** Resource route for slider*/
    Route::resource('slider', SliderController::class);

    /** Resource route for why choose us*/
    Route::put('why-choose-us-title/update', [WhyChooseUsController::class, 'updateTitle'])->name(
        'why-choose-title.update'
    );
    Route::resource('why-choose-us', WhyChooseUsController::class);

    /**Product Category Route */
    Route::resource('category', CategoryController::class);

    /** Resource route for product creation */
    Route::resource('product', ProductController::class);
    Route::put('product-title/update', [ProductController::class, 'updateTitle'])->name('product-title.update');

    /**Resource route for product gallery */
    Route::get('product/gallery/{product}', [ProductGalleryController::class, 'index'])->name('product.gallery.index');
    Route::resource('product-gallery', ProductGalleryController::class);


    /**Resource route for product size */
    Route::get('product/size/{product}', [ProductSizeController::class, 'index'])->name('product.size.index');
    Route::resource('product-size', ProductSizeController::class);



    /**Resource route for product option */
    Route::resource('product-option', ProductOptionController::class);

    /**Product review Route */
    Route::get('product-review', [ProductReviewController::class, 'productReviewIndex'])->name('product-review.index');
    Route::post('product-review', [ProductReviewController::class, 'reviewStatusUpdate'])->name('review.status.update');
    Route::delete('review/delete/{id}', [ProductReviewController::class, 'reviewDestroy'])->name('review.destroy');

    /**Resource Route for managing coupon */
    Route::resource('/coupon', CouponController::class);

    /**Admin Management Route */
    Route::resource('admin-management', AdminManagementController::class);

    /**Blogs Category Route */
    Route::resource('blogs-category', BlogCategoryController::class);

    /**Daily offer route */
    Route::put('daily-offer-title/update', [DailyOfferController::class, 'updateTitle'])->name(
        'daily-offer-title.update'
    );
    Route::get('/daily-offer/product-search', [DailyOfferController::class, 'productSearch'])->name('daily-offer.product-search');
    Route::resource('/daily-offer', DailyOfferController::class);

    /**Banner slider route */
    Route::resource('banner-slider', BannerSliderController::class);

    /**Chef Team Route */
    Route::put('chef-team-title/update', [ChefTeamController::class, 'updateTitle'])->name(
        'chef-team-title.update'
    );
    Route::resource('chef-team', ChefTeamController::class);

    /**Testimonial Route */
    Route::put('testimonial-title/update', [TestimonialController::class, 'updateTitle'])->name(
        'testimonial-title.update'
    );
    Route::resource('/testimonial', TestimonialController::class);

    /**Reservation Route */
    Route::get('reservation', [ReservationController::class, 'reservationsIndex'])->name('reservation.index');
    Route::post('reservation', [ReservationController::class, 'reservationsUpdate'])->name('reservation.status.update');
    Route::delete('reservation/delete/{id}', [ReservationController::class, 'reservationsDestroy'])->name('reservation.destroy');
    Route::resource('reservation-time', ReservationTimeController::class);

    /**Newsletter Route */
    Route::get('newsletter', [NewsletterController::class, 'index'])->name('newsletter-subscribers.index');
    Route::post('send/newsletter', [NewsletterController::class, 'sendNewsletter'])->name('newsletter-subscribers.message');

    /**Social Links Route */
    Route::resource('social-links', SocialLinksController::class);

    /**Footer Routes */
    Route::get('footer-info', [FooterController::class, 'index'])->name('footer-info.index');
    Route::put('footer-info/update', [FooterController::class, 'updateFooterInfo'])->name('footer-info.update');

    /**About Page Routes */
    Route::get('about-page/index', [AboutController::class, 'aboutPageIndex'])->name('about-page.index');
    Route::put('about-page/update', [AboutController::class, 'aboutPageUpdate'])->name('about-page.update');

    /**Menu-builder Route */
    Route::get('menu-builder', [MenuBuilderController::class, 'index'])->name('menu-builder.index');

    /**Custom Page Builder Route */
    Route::resource('custom-page-builder', CustomPageBuilderController::class);

    /**Terms & Cons Route */
    Route::get('privacy-policy', [PrivacyPolicyController::class, 'index'])->name('privacy-policy.index');
    Route::put('privacy-policy/update', [PrivacyPolicyController::class, 'privacyPolicyUpdate'])->name('privacy-policy.update');


    /**Privacy Policy Route */
    Route::get('terms&conditions', [TermsAndConditionController::class, 'index'])->name('terms&condition.index');
    Route::put('terms&conditions/update', [TermsAndConditionController::class, 'termsAndConditionsUpdate'])->name('terms_and_conditions.update');

    /**Contact Details Route */
    Route::get('contact', [ContactController::class, 'contact'])->name('contact.index');
    Route::put('contact/update', [ContactController::class, 'contactUpdate'])->name('contact.update');

    /**Blog comment route */
    Route::get('blogs/comments', [BlogController::class, 'blogsComments'])->name('blogs.comments.index');
    Route::get('blogs/comments/update/{id}', [BlogController::class, 'updateComment'])->name('blogs.comments.update');
    Route::delete('blogs/comments/delete/{id}', [BlogController::class, 'destroyComment'])->name('blogs.comments.destroy');
    /**Blog route */
    Route::resource('blogs', BlogController::class);

    /**App download Route */
    Route::get('/app-download', [AppDownloadController::class, 'index'])->name('app-download.index');
    Route::put('/app-download/store', [AppDownloadController::class, 'store'])->name('app-download.store');

    /**Counter Route */
    Route::get('/counter', [CounterController::class, 'index'])->name('counter.index');
    Route::put('/counter/store', [CounterController::class, 'store'])->name('counter.store');

    /**Order Routes */
    Route::get('all-orders', [OrdersController::class, 'index'])->name('all-orders');
    Route::get('view-order/{id}', [OrdersController::class, 'viewOrder'])->name('order.view');
    Route::put('order/status/update/{id}', [OrdersController::class, 'updateOrderStatus'])->name('orders.status.update');
    Route::get('order/status/{id}', [OrdersController::class, 'getOrderStatus'])->name('orders.status.get');
    Route::delete('all-orders/delete/{id}', [OrdersController::class, 'deleteOrder'])->name('all-orders.delete');
    Route::get('pending-orders', [OrdersController::class, 'pendingOrders'])->name('pending-orders');
    Route::get('processing-orders', [OrdersController::class, 'processingOrders'])->name('processing-orders');
    Route::get('delivered-orders', [OrdersController::class, 'deliveredOrders'])->name('delivered-orders');
    Route::get('declined-orders', [OrdersController::class, 'declinedOrders'])->name('declined-orders');

    /**Route for order placed notification */
    Route::get('clear-notification', [AdminDashboardController::class, 'clearNotification'])->name('clear-notification');

    /**Route for Daily Offer*/
    Route::resource('/delivery-area', DeliveryAreaController::class);

    /**Route for general settings */
    Route::get('/settings', [GeneralSettingsController::class, 'index'])->name('settings');
    Route::put('/general/settings', [GeneralSettingsController::class, 'updateGeneralSettings'])->name('general.settings.update');

    /**Pusher setting route */
    Route::put('pusher-settings', [GeneralSettingsController::class, 'updatePusherSettings'])->name('pusher-settings.update');
    Route::put('mail-settings', [GeneralSettingsController::class, 'updateMailSettings'])->name('mail-settings.update');

    /**Logo settings route */
    Route::put('logo-settings', [GeneralSettingsController::class, 'updateLogoSettings'])->name('logo-settings.update');

    /**Appearance Setting Route */
    Route::put('appearance-settings', [GeneralSettingsController::class, 'updateAppearanceSettings'])->name('appearance-settings.update');

    /**SEO Setting Route */
    Route::put('seo-settings', [GeneralSettingsController::class, 'updateSeoSettings'])->name('seo-settings.update');

    /**Clear Database Route */
    Route::get('clear-database', [ClearDatabaseController::class, 'index'])->name('clear-database.index');
    Route::post('clear-database', [ClearDatabaseController::class, 'clearDatabase'])->name('clear-database.destroy');

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    /** Update profile route */
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');

    /** Update password route */
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    Route::get('/gateway/payment-settings', [PaymentGatewaySettingsController::class, 'index'])->name('payment-settings.index');
    Route::put('/paypal-settings', [PaymentGatewaySettingsController::class, 'paypalSettingUpdate'])->name('paypal-settings.update');

    Route::put('/stripe-settings', [PaymentGatewaySettingsController::class, 'stripeSettingUpdate'])->name('stripe-settings.update');

    Route::put('/razorpay-settings', [PaymentGatewaySettingsController::class, 'razorpaySettingUpdate'])->name('razorpay-settings.update');

    /**Message route */
    Route::get('chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('chat/get-message/{senderId}', [ChatController::class, 'getMessage'])->name('chat.get-message');
    Route::post('/chat/send-message/', [ChatController::class, 'sendMessage'])->name('chat.send-message');
});
