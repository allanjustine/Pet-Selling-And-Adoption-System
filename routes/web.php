<?php

// Facades
use Illuminate\Support\Facades\{
    Artisan,
    Auth,
    Route
};

use App\Http\Controllers\Auth\{
    AuthController
};

// Shared Restful Controllers
use App\Http\Controllers\All\{
    ProfileController,
    TmpImageUploadController
};

// Admin Restful Controllers
use App\Http\Controllers\Admin\{
    ActivityLogController,
    AdditionalPaymentController as AdminAdditionalPaymentController,
    AdminController,
    AdoptionController as AdminAdoptionController,
    BreedController,
    BuyerController,
    DashboardController,
    CategoryController,
    GeneralReportController,
    OrderController as AdminOrderController,
    PaymentMethodController,
    PetController,
    PrintController,
    SellerAccountController as AdminSellerAccountController,
    SellerController as AdminSellerController,
    UserController
};

// Seller Restful Controllers
use App\Http\Controllers\Seller\{
    AdoptionController,
    DashboardController as SellerDashboardController,
    MarkAsAdoptedController,
    MarkAsDeliveredController,
    OrderController as SellerOrderController,
    PetController as SellerPetController
};

// Buyer Restful Controllers
use App\Http\Controllers\Buyer\{
    AdditionalPaymentController,
    AdoptionController as BuyerAdoptionController,
    DashboardController as BuyerDashboardController,
    OrderController,
    OrderReceivedController,
    OtpController,
    PetController as BuyerPetController,
    RatingController,
    SellerAccountController,
    SellerController,
    SwitchAccountController
};

// Shared Restful Controllers
use App\Http\Controllers\Shared\{
    CommentController,
    LikeController,
    MessageController
};

Route::get('/', function () {
    return to_route('auth.login');
});

Route::view('/install', 'install')->name('app.install');

// caching
Route::get('/cache', function () {
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    return 'cache';
});

// Route::get('/symlink', function () {
//     symlink('/home/u686793928/iskool/storage/app/public', '/home/u686793928/domains/mainsandbox.com/public_html/sub_iskool/storage');
// });


// Admin 
Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin', 'as' => 'admin.'],function() {
    Route::get('dashboard', DashboardController::class)->name('dashboard.index');

    /** Start User Management */
        Route::resource('admins', AdminController::class);
        Route::resource('buyers', BuyerController::class);
        Route::resource('sellers', AdminSellerController::class);
        Route::resource('users', UserController::class);
    /** End User Management */

    
    /** Start Pet Management */
        Route::resource('categories', CategoryController::class);
        Route::resource('breeds', BreedController::class);
        Route::resource('pets', PetController::class);
        Route::resource('adoptions', AdminAdoptionController::class);

    /** End Pet Management */

    /** Start Order Management */
        Route::resource('orders', AdminOrderController::class);
        Route::put('orders/{order}/additional_payment/{additional_payment}/update', AdminAdditionalPaymentController::class)->name('orders.additional_payments.update');
        Route::resource('payment_methods', PaymentMethodController::class);
    /** Start Order Management */


    Route::get('activity_logs', ActivityLogController::class)->name('activity_logs.index');

    Route::get('print', PrintController::class)->name('print.handle');

    Route::get('general_report', GeneralReportController::class)->name('general_report.index');


});


// Seller 
Route::group(['middleware' => ['auth', 'seller'], 'prefix' => 'seller', 'as' => 'seller.'],function() {
    Route::get('dashboard', SellerDashboardController::class)->name('dashboard.index');
    Route::put('switch_account/{user}', SwitchAccountController::class)->name('switch_account.update');
    Route::resource('pets', SellerPetController::class);

    Route::resource('orders', SellerOrderController::class)->only('index', 'show');

    Route::put('orders/{order}/mark_as_delivered', MarkAsDeliveredController::class)->name('orders.mark_as_delivered');


    Route::put('adoptions/{adoption}/mark_as_adopted', MarkAsAdoptedController::class)->name('adoptions.mark_as_adopted');

    Route::resource('adoptions', AdoptionController::class);

});


// Buyer 
Route::group(['middleware' => ['auth', 'buyer'], 'prefix' => 'buyer', 'as' => 'buyer.'],function() {

    /** Start Extras */
        Route::get('dashboard', BuyerDashboardController::class)->name('dashboard.index');
        Route::put('switch_account/{user}', SwitchAccountController::class)->name('switch_account.update');
    /** End Extras */

    /** Start Seller Account */
        Route::get('sellers/{seller}', SellerController::class)->name('sellers.show');
        Route::resource('seller_accounts', SellerAccountController::class)->except('index');
    /** End Seller Account */

    /** Start Shopping */
        Route::post('/send_otp', OtpController::class)->name('otp.store'); //Send OTP
        Route::resource('pets.orders', OrderController::class)->only('create', 'store');
        Route::resource('orders', OrderController::class)->only('index', 'show');
        Route::resource('orders.additional_payments', AdditionalPaymentController::class)->only('create', 'store');
        Route::resource('additional_payments', AdditionalPaymentController::class)->only('index', 'show');
        Route::put('orders/{order}/received', OrderReceivedController::class)->name('orders.received');
        Route::resource('pets', BuyerPetController::class);
    /** End Shopping */


    /** Start Ratings */
        Route::post('/orders/{order}/ratings', RatingController::class)->name('ratings.store');
    /** End Ratings */


    /** Start Community */
        Route::resource('adoptions', BuyerAdoptionController::class)->only('index', 'show');
    /** End Community */

});


// Shared Controller
Route::group(['middleware' => ['auth']],function() {

    // TMP FILE UPLOAD
    Route::delete('tmp_upload/revert', [TmpImageUploadController::class, 'revert']);
    Route::post('tmp_upload/content', [TmpImageUploadController::class, 'faqImageUpload'])->name('tmpupload.faqImageUpload');
    Route::resource('tmp_upload', TmpImageUploadController::class);
    Route::resource('profile', ProfileController::class)->parameter('profile', 'user');

    // likes & comments
    Route::resource('likes', LikeController::class)->only('store', 'destroy');
    Route::resource('comments', CommentController::class)->except('index', 'show');

    // Messages
    Route::resource('messages', MessageController::class);
  
});

Route::group(['as' => 'auth.', 'controller' => AuthController::class],function() {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'attemptLogin')->name('attemptLogin');
    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'attemptRegister')->name('attemptRegister');
    Route::post('/logout', 'logout')->name('logout');

    Route::get('/email/verify/{token}', 'emailVerification')->name('email_verification'); // email verification
});


Auth::routes(['login' => false, 'register' => false, 'logout' => false]);