<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Front\UserAuthController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\OrderController;
use App\Http\Controllers\Front\PaymentController;
use App\Http\Middleware\CheckUserLog;
use App\Libraries\Gwapi;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//    /// dd('Welcome to web routes.');
// });

Route::get('/', [PageController::class, 'index']);
Route::get('signup', [UserAuthController::class, 'signup']);
Route::post('save-user', [UserAuthController::class, 'saveUser']);
Route::get('signin', [UserAuthController::class, 'signin']);
Route::get('forgot-password', [UserAuthController::class, 'forgotPassword']);
Route::post('reset-password', [UserAuthController::class, 'resetPassword']);
Route::get('get-password', [UserAuthController::class, 'getPassword']);
Route::post('update-reset-password', [UserAuthController::class, 'updateResetPassword']);
Route::post('user-auth', [UserAuthController::class, 'userAuth']);
Route::get('logout', [UserAuthController::class, 'logout']);
Route::get('about-us', [PageController::class, 'aboutUs']);
Route::get('contact-us', [PageController::class, 'contactUs']);
Route::post('save-enquiry', [PageController::class, 'saveEnquiry']);
Route::get('privacy-policy', [PageController::class, 'privacyPolicy']);
Route::get('vendors', [PageController::class, 'vendors']);
Route::get('products', [ProductController::class, 'products']);
Route::get('product-details/{slug}', [ProductController::class, 'productDetails']);

Route::get('products/{slug}', [ProductController::class, 'categoryProducts']);
Route::get('display-products', [ProductController::class, 'displayProducts']);
Route::get('display-product-details/{slug}', [ProductController::class, 'displayProductDetails']);
Route::get('search-products', [ProductController::class, 'searchProducts']);

Route::get('custom/{slug}', [ProductController::class, 'customCategoryProducts']);
Route::get('custom-category', [ProductController::class, 'customCategory']);
Route::get('custom-product-details/{slug}', [ProductController::class, 'customProductDetails']);

Route::post('save-product-enquiry', [ProductController::class, 'saveProductEnquiry']);
Route::get('get-price-size', [ProductController::class, 'getPriceSize']);
Route::get('cart', [CartController::class, 'cart']);
Route::post('add-cart', [CartController::class, 'addCart']);
Route::post('update-cart', [CartController::class, 'updateCart']);
Route::get('remove-cart/{id}', [CartController::class, 'removeCart']);

Route::get('test', [UserAuthController::class, 'testEmail']);
Route::get('invoice', [OrderController::class, 'invoice']);

Route::middleware([CheckUserLog::class])->group(function () {

    Route::get('checkout', [OrderController::class, 'checkout']);
    Route::post('check-coupon', [OrderController::class, 'checkCoupon']);
    Route::post('order-process', [OrderController::class, 'orderProcess']);
    Route::get('order-success', [OrderController::class, 'orderSuccess']);
    Route::get('payment', [PaymentController::class, 'orderPayment']);
    Route::post('pay-process', [PaymentController::class, 'payProcess']);

    Route::get('user/index', [UserController::class, 'index']);
    Route::get('user/order-list', [UserController::class, 'orderList']);
    Route::get('user/display-order-list', [UserController::class, 'displayOrderList']);
    Route::get('user/custom-order-list', [UserController::class, 'customOrderList']);
    Route::get('user/profile', [UserController::class, 'profile']);
    Route::post('user/update-profile', [UserController::class, 'updateProfile']);
    Route::get('user/change-password', [UserController::class, 'changePassword']);
    Route::post('user/update-password', [UserController::class, 'updatePassword']);
});
