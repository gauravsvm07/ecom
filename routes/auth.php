<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckAdminLog;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\UsetipController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomCategoryController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\MedalPriceController;

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

Route::prefix('auth')->group(function () {
    Route::get('/', [AdminAuthController::class, 'login']);
    Route::post('authenticate', [AdminAuthController::class, 'authenticate']);
    Route::get('login', [DashboardController::class, 'login']);
});

Route::prefix('auth')->middleware([CheckAdminLog::class])->group(function () {

    Route::get('index', [DashboardController::class, 'index']);
    Route::get('my-profile', [AdminAuthController::class, 'myProfile']);
    Route::post('update-profile', [AdminAuthController::class, 'updateProfile']);
    Route::post('update-password', [AdminAuthController::class, 'updatePassword']);
    Route::get('general-settings', [SettingController::class, 'generalSettings']);
    Route::post('update-setting', [SettingController::class, 'updateSetting',]);
    Route::get('admin-logout', [AdminAuthController::class, 'adminLogout']);
    Route::get('lock-screen', [DashboardController::class, 'lockScreen']);
    Route::get('forgot-password', [DashboardController::class, 'forgotPassword']);

    Route::get('category-list', [CategoryController::class, 'categoryList']);
    Route::get('add-category', [CategoryController::class, 'categoryForm']);
    Route::get('edit-category/{id}', [CategoryController::class, 'categoryForm']);
    Route::post('save-category', [CategoryController::class, 'saveCategory']);
    Route::post('update-status', [CategoryController::class, 'updateStatus']);
    Route::post('delete-category', [CategoryController::class, 'deleteCategory']);

    Route::get('custom-category-list', [CustomCategoryController::class, 'customCategoryList']);
    Route::get('add-custom-category', [CustomCategoryController::class, 'customCategoryForm']);
    Route::get('edit-custom-category/{id}', [CustomCategoryController::class, 'customCategoryForm']);
    Route::post('save-custom-category', [CustomCategoryController::class, 'saveCustomCategory']);
    Route::post('delete-custom-category', [CustomCategoryController::class, 'deleteCustomCategory']);

    Route::get('payment-list', [DashboardController::class, 'paymentList']);
    Route::get('order-list', [DashboardController::class, 'orderList']);
    Route::get('invoice', [DashboardController::class, 'invoice']);
    Route::get('get-order-products', [DashboardController::class, 'getOrderProducts']);
    Route::get('get-order-address', [DashboardController::class, 'getOrderAddress']);
    Route::get('change-order-status', [DashboardController::class, 'changeOrderStatus']);
    Route::get('custom-order', [DashboardController::class, 'customOrder']);

    Route::get('madel-price-list', [MedalPriceController::class, 'medalPriceList']);
    Route::get('edit-madel-price/{id}', [MedalPriceController::class, 'medalPriceForm']);
    Route::post('save-madel-price', [MedalPriceController::class, 'saveMedalPrice']);

    Route::get('page-category-list', [CmsController::class, 'pageCategoryList']);
    Route::get('add-page-category', [CmsController::class, 'pageCategoryForm']);
    Route::get('edit-page-category/{id}', [CmsController::class, 'pageCategoryForm']);
    Route::post('save-page-category', [CmsController::class, 'savePageCategory']);
    Route::post('delete-page-category', [CmsController::class, 'deletePageCategory']);


    Route::get('page-section-list', [CmsController::class, 'pageSectionList']);
    Route::get('add-page-section', [CmsController::class, 'pageSectionForm']);
    Route::get('edit-page-section/{id}', [CmsController::class, 'pageSectionForm']);
    Route::post('save-page-section', [CmsController::class, 'savePageSection']);
    Route::post('delete-page-section', [CmsController::class, 'deletePageSection']);


    Route::get('page-list', [CmsController::class, 'pageList']);
    Route::get('add-page', [CmsController::class, 'pageForm']);
    Route::get('edit-page/{id}', [CmsController::class, 'pageForm']);
    Route::post('save-page', [CmsController::class, 'savePage']);
    Route::post('delete-page', [CmsController::class, 'deletePage']);

    Route::get('get-page-section', [CmsController::class, 'getPageSection']);

    Route::get('module-list', [ModuleController::class, 'moduleList']);
    Route::get('add-module', [ModuleController::class, 'moduleForm']);
    Route::get('edit-module/{id}', [ModuleController::class, 'moduleForm']);
    Route::post('save-module', [ModuleController::class, 'saveModule']);
    Route::post('delete-module', [ModuleController::class, 'deleteModule']);

    Route::get('role-list', [RoleController::class, 'roleList']);
    Route::get('add-role', [RoleController::class, 'roleForm']);
    Route::get('edit-role/{id}', [RoleController::class, 'roleForm']);
    Route::post('save-role', [RoleController::class, 'saveRole']);
    Route::post('delete-role', [RoleController::class, 'deleteRole']);

    Route::get('permission-list', [PermissionController::class, 'permissionList']);
    Route::get('add-permission', [PermissionController::class, 'permissionForm']);
    Route::get('edit-permission/{id}', [PermissionController::class, 'permissionForm']);
    Route::post('save-permission', [PermissionController::class, 'savePermission']);
    Route::post('delete-permission', [PermissionController::class, 'deletePermission']);

    Route::get('admin-list', [AdminController::class, 'adminList']);
    Route::get('add-admin', [AdminController::class, 'adminForm']);
    Route::get('edit-admin/{id}', [AdminController::class, 'adminForm']);
    Route::post('save-admin', [AdminController::class, 'saveAdmin']);
    Route::post('delete-admin', [AdminController::class, 'deleteAdmin']);

    Route::get('newsletter-emails', [NewsletterController::class, 'newsletterEmails']);
    Route::post('delete-newsletter-email', [NewsletterController::class, 'deleteNewsletterEmail']);

    Route::get('banner-list', [BannerController::class, 'bannerList']);
    Route::get('add-banner', [BannerController::class, 'bannerForm']);
    Route::get('edit-banner/{id}', [BannerController::class, 'bannerForm']);
    Route::post('save-banner', [BannerController::class, 'saveBanner']);
    Route::post('delete-banner', [BannerController::class, 'deleteBanner']);

    Route::get('email-template-list', [EmailTemplateController::class, 'emailTemplateList']);
    Route::get('add-email-template', [EmailTemplateController::class, 'emailTemplateForm']);
    Route::get('edit-email-template/{id}', [EmailTemplateController::class, 'emailTemplateForm']);
    Route::post('save-email-template', [EmailTemplateController::class, 'saveEmailTemplate']);
    Route::post('delete-email-template', [EmailTemplateController::class, 'deleteEmailTemplate']);

    Route::get('coupon-list', [CouponController::class, 'couponList']);
    Route::get('add-coupon', [CouponController::class, 'couponForm']);
    Route::get('edit-coupon/{id}', [CouponController::class, 'couponForm']);
    Route::post('save-coupon', [CouponController::class, 'saveCoupon']);
    Route::post('delete-coupon', [CouponController::class, 'deleteCoupon']);

    Route::get('feature-list', [FeatureController::class, 'featureList']);
    Route::get('add-feature', [FeatureController::class, 'featureForm']);
    Route::get('edit-feature/{id}', [FeatureController::class, 'featureForm']);
    Route::post('save-feature', [FeatureController::class, 'saveFeature']);
    Route::post('delete-feature', [FeatureController::class, 'deleteFeature']);

    Route::get('package-list', [PackageController::class, 'packageList']);
    Route::get('add-package', [PackageController::class, 'packageForm']);
    Route::get('edit-package/{id}', [PackageController::class, 'packageForm']);
    Route::post('save-package', [PackageController::class, 'savePackage']);
    Route::post('delete-package', [PackageController::class, 'deletePackage']);

    Route::get('general-product-list', [ProductController::class, 'generalProductList']);
    Route::get('add-general-product', [ProductController::class, 'generalProductForm']);
    Route::get('copy-general-product/{product_id}', [ProductController::class, 'copyGeneralProductForm']);
    Route::get('edit-general-product/{id}', [ProductController::class, 'generalProductForm']);
    Route::post('save-general-product', [ProductController::class, 'saveGeneralProduct']);
    Route::post('save-copy-general-product', [ProductController::class, 'saveCopyGeneralProduct']);
    Route::get('search-products', [ProductController::class, 'searchProducts']);


    Route::get('custom-product-list', [ProductController::class, 'customProductList']);
    Route::get('add-custom-product', [ProductController::class, 'customProductForm']);
    Route::get('edit-custom-product/{id}', [ProductController::class, 'customProductForm']);
    Route::post('save-custom-product', [ProductController::class, 'saveCustomProduct']);

    Route::get('display-product-list', [ProductController::class, 'displayProductList']);
    Route::get('add-display-product', [ProductController::class, 'displayProductForm']);
    Route::get('edit-display-product/{id}', [ProductController::class, 'displayProductForm']);
    Route::post('save-display-product', [ProductController::class, 'saveDisplayProduct']);


    Route::post('delete-product', [ProductController::class, 'deleteProduct']);
    Route::get('delete-product-image/{id}', [ProductController::class, 'deleteProductImage']);

    Route::get('display-order', [ProductController::class, 'displayOrder']);




    Route::get('user-list', [UserController::class, 'userList']);
    Route::get('add-user', [UserController::class, 'userForm']);
    Route::post('save-user', [UserController::class, 'saveUser']);
    Route::get('edit-user/{id}', [UserController::class, 'userForm']);
    Route::get('view-user/{uuid}', [UserController::class, 'viewUser']);
    Route::post('update-user-status', [UserController::class, 'updateUserStatus']);
    Route::post('delete-user', [UserController::class, 'deleteUser']);
    Route::get('search-user', [UserController::class, 'searchUser']);

    Route::get('enquiry-list', [EnquiryController::class, 'enquiryList']);
    Route::get('view-enquiry/{id}', [EnquiryController::class, 'viewEnquiry']);
    Route::delete('delete-all-enquiry', [EnquiryController::class, 'deleteAllEnquiry']);

    Route::get('state-list', [LocationController::class, 'stateList']);
    Route::get('add-state', [LocationController::class, 'stateForm']);
    Route::get('edit-state/{id}', [LocationController::class, 'stateForm']);
    Route::post('save-state', [LocationController::class, 'saveState']);
    Route::post('delete-state', [LocationController::class, 'deleteState']);
});
