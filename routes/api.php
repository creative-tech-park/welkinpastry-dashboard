<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\PageController;
use App\Http\Controllers\Api\V1\BrandController;
use App\Http\Controllers\Api\V1\ImageController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\ReviewController;
use App\Http\Controllers\Api\V1\SliderController;
use App\Http\Controllers\Api\V1\AddressController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\LocationController;
use App\Http\Controllers\Api\V1\DashboardController;
use App\Http\Controllers\Api\V1\OrderAreaController;
use App\Http\Controllers\Api\V1\CustomCakeController;
use App\Http\Controllers\Api\v1\TestimonialController;
use App\Http\Controllers\Api\Frontend\V1\HomeController;
use App\Http\Controllers\Api\V1\CompanyServiceController;
use App\Http\Controllers\Api\V1\BusinessSettingController;
use App\Http\Controllers\Api\V1\CustomCakeOrderController;
use App\Http\Controllers\Auth\Customer\RegisterController;
use App\Http\Controllers\Api\V1\CustomCakeFlavorController;
use App\Http\Controllers\Api\Frontend\V1\GetInTouchController;
use App\Http\Controllers\Api\Frontend\V1\CustomerOrderController;
use App\Http\Controllers\Auth\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Auth\Customer\LoginController as CustomerLoginController;
use App\Http\Controllers\Api\Frontend\V1\ProductController as FrontendProductController;
use App\Http\Controllers\Api\Frontend\V1\CustomerController as FrontendCustomerController;
// authenticated user
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');






Route::prefix('frontend/v1')->middleware(['throttle:api'])->group(function () {

    Route::get('/homedata', [HomeController::class, 'getHomeData']);

    // Frontend Route Customer Auth
    Route::post('/customer/login', [CustomerLoginController::class, 'login']);
    Route::post('/customer/register', [RegisterController::class, 'register']);


    // get product categories
    Route::get('/categories', [HomeController::class, 'categories']);
    Route::get('/all-categories', [HomeController::class, 'allCategories']);
    Route::get('/filter-products', [HomeController::class, 'filterProducts']);
    Route::get('/best-selling-product', [FrontendProductController::class, 'bestSelling']);

    // home products
    Route::apiResource('product', FrontendProductController::class);
    Route::get('/category-products', [HomeController::class, 'getSelectedCategoryProducts']);
    // get all business location
    Route::get('/business-locations', [HomeController::class, 'getBusinessLocations']);

    // get all pages
    Route::get('/pages', [HomeController::class, 'getAllpages']);
    Route::get('/pages/{id}', [HomeController::class, 'getSinglePage']);

    Route::get('/all-reviews', [ReviewController::class, 'index']);

    Route::post('/create-message', [GetInTouchController::class, 'store']);

    // get frontend settings
    Route::get('/get-settings', [HomeController::class, 'getAllSettings']);

    Route::get('/testimonials', [HomeController::class, 'getTestimonials']);
    Route::get('/services', [HomeController::class, 'getServices']);
    Route::get('/custom-cakes', [HomeController::class, 'getCustomCakes']);
    Route::get('/custom-cake/show/{id}', [HomeController::class, 'showCustomCake']);
    Route::post('/save-custom-cake-order', [OrderController::class, 'customCakeOrder']);
    Route::post('/buy-now-order', [OrderController::class, 'buyNowOrder']);
    Route::get('order-areas', [AddressController::class, 'getOrderAreas']);


    Route::middleware('auth:sanctum')->group(function () {
        // dashboard data
        Route::get('/dashboard-data', [CustomerController::class, 'dashboardData']);

        // customer order area and address
        Route::post('save-shipping-address', [AddressController::class, 'store']);
        Route::get('my-shipping-address', [AddressController::class, 'index']);
        Route::get('/edit-my-shipping-address/{id}', [AddressController::class, 'store']);
        Route::delete('/delete-my-shipping-address/{id}', [AddressController::class, 'destroy']);
        Route::get('single-shipping-address/{id}', [AddressController::class, 'show']);


        // customer order
        Route::post('/save-order', [OrderController::class, 'store']);
        Route::get('/get-customer-order', [CustomerOrderController::class, 'customerOrders']);
        Route::get('/custom-cake-orders', [CustomerOrderController::class, 'customCakeOrders']);
        Route::get('/order-detail/{id}', [CustomerOrderController::class, 'showCustomerOrder']);

        //SslCommerz route
        Route::post('/pay', [\App\Http\Controllers\SslCommerzPaymentController::class, 'index']);
        Route::post('/ipn', [\App\Http\Controllers\SslCommerzPaymentController::class, 'ipn']);
    });
    Route::post('/success', [\App\Http\Controllers\SslCommerzPaymentController::class, 'success']);
    Route::post('/fail', [\App\Http\Controllers\SslCommerzPaymentController::class, 'cancel']);
    Route::post('/cancel', [\App\Http\Controllers\SslCommerzPaymentController::class, 'cancel']);
});



// admin panel Auth routes
Route::prefix('v1')->middleware(['auth:sanctum', 'throttle:api', 'type.admin'])->group(function () {

    Route::withoutMiddleware(['auth:sanctum', 'type.admin'])->group(function () {
        // Admin Guest Route
        Route::post('/login', [AdminLoginController::class, 'login']);
    });

    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/delete-product-image', [ProductController::class, 'deleteImage']);
    Route::get('/get-all-product-list', [ProductController::class, 'getAllProductList']);
    Route::get('/parent-category', [CategoryController::class, 'index']);
    Route::get('/get-all-category-list', [CategoryController::class, 'getAllCategoryList']);
    Route::get('/get-all-brand-list', [BrandController::class, 'getAllBrandList']);
    Route::get('/all-page-list', [PageController::class, 'allPageList']);



    Route::get('/get-in-touch', [GetInTouchController::class, 'index']);
    Route::delete('/delete-get-in-touch/{id}', [GetInTouchController::class, 'destroy']);
    Route::get('/settings', [BusinessSettingController::class, 'index']);
    Route::post('/settings', [BusinessSettingController::class, 'updateSetting']);

    Route::get('/page-delete/{id}', [PageController::class, 'destroy']);
    Route::delete('/reviews-delete/{id}', [ReviewController::class, 'destroy']);

    Route::post('/order-status/{id}', [OrderController::class, 'changeOrderStatus']);




    Route::post('/update-product', [ProductController::class, 'update']);
    Route::apiResources([
        'location' => LocationController::class,
        'product' => ProductController::class,
        'customer' => CustomerController::class,
        'slider' => SliderController::class,
        'category' => CategoryController::class,
        'brand' => BrandController::class,
        'order' => OrderController::class,
        'page' => PageController::class,
        'reviews' => ReviewController::class,
        'shipping-area' => OrderAreaController::class,
        'testimonials' => TestimonialController::class,
        'services' => CompanyServiceController::class,
        'custom-cakes' => CustomCakeController::class,
        'custom-cake-flavors' => CustomCakeFlavorController::class,
        'custom-cake-orders' => CustomCakeOrderController::class,
    ]);


    Route::get('/get-settings', [BusinessSettingController::class, 'getAllSettings']);
    Route::put('/profile-update', [AdminLoginController::class, 'updateProfile']);
    Route::post('/password-update', [AdminLoginController::class, 'updatePassword']);

    Route::any('/logout', [AdminLoginController::class, 'logout']);
});


Route::get("/storage", function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    return "storage linked";
});

// download file api

Route::get('/download/{file}', function ($file) {
    $filePath = storage_path('app/public/photo_on_cakes/' . $file);

    if (!file_exists($filePath)) {
        return response()->json(['error' => 'File not found'], 404);
    }
    return Response::download($filePath);
});