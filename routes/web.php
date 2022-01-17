<?php

use App\Http\Controllers\AccountsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PagesController; //Include the controller
use App\Http\Controllers\StoreController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductCategoriesController;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\SalesReportsController;
use App\Mail\OrderMail;

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


Auth::routes();
 
Route::resource('products', ProductsController::class);

//For user/customer
Route::middleware(['auth:sanctum', 'verified']) -> group(function()
{
    //User Dashboard Controller
    Route::get('/user/dashboard',[UserDashboardController::class, 'showUserDashboard'])->name('user.userDashboard');
    
    Route::get('/user/orders/all',[UserDashboardController::class, 'showOrderAll'])->name('user.showOrderAll');
    Route::get('/user/orders/ordered',[UserDashboardController::class, 'showOrderOrdered'])->name('user.showOrderOrdered');
    Route::get('/user/orders/shipped',[UserDashboardController::class, 'showOrderShipped'])->name('user.showOrderShipped');
    Route::get('/user/orders/delivered',[UserDashboardController::class, 'showOrderDelivered'])->name('user.showOrderDelivered');
    Route::get('/user/orders/canceled',[UserDashboardController::class, 'showOrderCanceled'])->name('user.showOrderCanceled');
    Route::get('/user/account',[UserDashboardController::class, 'showAccountSettings'])->name('user.showAccountSettings');
    Route::match(['put', 'patch'], 'updateUserInfo',[UserDashboardController::class, 'updateUserInfo'])->name('user.updateUserInfo');
    Route::post('userDashboardCheckEmailAndMobile',[UserDashboardController::class, 'userDashboardCheckEmailAndMobile']);
    Route::match(['put', 'patch'], 'changeUserPassword',[UserDashboardController::class, 'changeUserPassword'])->name('user.changeUserPassword');

    //Cart Controller
    Route::get('/cart',[PagesController::class, 'cart'])->name('pages.cart');
    Route::get('/cart/checkout',[PagesController::class, 'showCheckout'])->name('pages.checkout');
    Route::post('/addToCart',[PagesController::class, 'addToCart'])->name('user.addToCart');
    Route::post('/removeFromCart',[PagesController::class, 'removeFromCart'])->name('user.removeFromCart');
    Route::post('increaseItemQty',[PagesController::class, 'increaseItemQty']);
    Route::post('decreaseItemQty',[PagesController::class, 'decreaseItemQty']);
    Route::post('setNumItemQty',[PagesController::class, 'setNumItemQty']);
    Route::get('/cart/checkout/placeOrder',[OrdersController::class, 'placeOrder']);

});

//For admin/staff
Route::middleware(['auth:sanctum', 'verified', 'authadmin']) -> group(function()
{
    //Admin Pages Controller
    Route::get('/admin/dashboard',[AdminDashboardController::class, 'showAdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/accounts',[PagesController::class, 'showAccountManagement'])->name('admin.account');
    Route::get('/admin/inventory',[PagesController::class, 'showInventory'])->name('admin.inventory');
    Route::get('/admin/orders',[PagesController::class, 'showOrderAll'])->name('admin.showOrderAll');
    Route::get('/admin/deliveries',[PagesController::class, 'showDeliveryManagement'])->name('admin.delivery');

    //Sales Report Page Controller
    Route::get('/admin/sales',[SalesReportsController::class, 'showSalesReport'])->name('admin.showSalesReport');
    Route::get('/admin/salesByDate',[SalesReportsController::class, 'showSalesReportByDate'])->name('admin.showSalesReportByDate');
    Route::get('/admin/salesByDate/sortFormat',[SalesReportsController::class, 'showSalesReportByDateFormat'])->name('admin.showSalesReportByDateFormat');
    
    //Item Inventory Controller
    Route::get('/products/create',[ProductsController::class, 'create']);
    Route::match(['put', 'patch'], 'updateProduct',[ProductsController::class, 'updateProduct'])->name('products.updateProduct');
    Route::delete('deleteProduct',[ProductsController::class, 'deleteProduct'])->name('products.deleteProduct');
    Route::get('/admin/inventory/lowOnStock',[ProductsController::class, 'showLowOnStock'])->name('products.showLowOnStock');
    Route::post('/products/createFromCsv',[ProductsController::class, 'uploadFromCsv'])->name('products.uploadFromCsv');
    
    //Item Inventory Controller
    Route::post('addProductCategory',[ProductCategoriesController::class, 'store'])->name('productCategories.store');
    Route::match(['put', 'patch'], 'updateProductCategory',[ProductCategoriesController::class, 'update'])->name('productCategories.update');
    Route::delete('deleteProductCategory',[ProductCategoriesController::class, 'destroy'])->name('productCategories.delete');

    //Accounts Controller
    Route::match(['put', 'patch'], 'editUserInfo',[AccountsController::class, 'editUserInfo'])->name('user.updateInfo');
    Route::delete('deleteUser',[AccountsController::class, 'deleteUser'])->name('user.deleteUser');

    //Orders Controller
    Route::get('/admin/orders/ordered',[OrdersController::class, 'showOrderOrdered'])->name('admin.showOrderOrdered');
    Route::get('/admin/orders/shipped',[OrdersController::class, 'showOrderShipped'])->name('admin.showOrderShipped');
    Route::get('/admin/orders/delivered',[OrdersController::class, 'showOrderDelivered'])->name('admin.showOrderDelivered');
    Route::get('/admin/orders/canceled',[OrdersController::class, 'showOrderCanceled'])->name('admin.showOrderCanceled');
    Route::get('/admin/orders/todaySales',[OrdersController::class, 'showTodaySales'])->name('admin.showTodaySales');
    Route::get('/admin/orders/totalSales',[OrdersController::class, 'showTotalSales'])->name('admin.showTotalSales');
    Route::get('/admin/orders/user/{id}',[OrdersController::class, 'showUserOrder'])->name('admin.showUserOrders');
    Route::get('/admin/orders/{id}',[OrdersController::class, 'showOrder'])->name('admin.showOrder');
    Route::delete('deleteOrder',[OrdersController::class, 'deleteOrder'])->name('user.deleteOrder');
    Route::post('updateStatusOrdered',[OrdersController::class, 'updateStatusOrdered'])->name('orders.updateStatusOrdered');
    Route::post('updateStatusShipped',[OrdersController::class, 'updateStatusShipped'])->name('orders.updateStatusShipped');
    Route::post('updateStatusDelivered',[OrdersController::class, 'updateStatusDelivered'])->name('orders.updateStatusDelivered');
    Route::post('updateStatusCanceled',[OrdersController::class, 'updateStatusCanceled'])->name('orders.updateStatusCanceled');

    //Admin Account Settings Controller

    Route::get('/admin/settings',[AdminSettingsController::class, 'showAdminSettings'])->name('admin.showAdminSettings');
    Route::match(['put', 'patch'], 'changeAdminPassword',[AdminSettingsController::class, 'changeAdminPassword'])->name('admin.changeAdminPassword');
    Route::match(['put', 'patch'], 'updateAdminInfo',[AdminSettingsController::class, 'updateInfo'])->name('admin.updateInfo');
    Route::post('addAdminAccount',[AdminSettingsController::class, 'addAdminAccount'])->name('admin.addAdminAccount');
    Route::delete('deleteAdminAcount',[AdminSettingsController::class, 'deleteAdminAcount'])->name('admin.deleteAdminAcount');
    Route::delete('deleteAllUserAccounts',[AdminSettingsController::class, 'deleteAllUserAccounts'])->name('admin.deleteAllUserAccounts');
    Route::delete('deleteAllItemInventory',[AdminSettingsController::class, 'deleteAllItemInventory'])->name('admin.deleteAllItemInventory');
    Route::delete('deleteAllOrderAndDelivery',[AdminSettingsController::class, 'deleteAllOrderAndDelivery'])->name('admin.deleteAllOrderAndDelivery');
    Route::delete('deleteAllRecords',[AdminSettingsController::class, 'deleteAllRecords'])->name('admin.deleteAllRecords');
    Route::post('checkAdminEmail',[AdminSettingsController::class, 'checkAdminEmail'])->name('admin.checkAdminEmail');
 
});

Auth::routes();

//Store Controller
Route::get('/',[PagesController::class, 'showLanding'])->name('store.showLanding');

Route::get('/store',[PagesController::class, 'showProducts'])->name('products.sortNameAtoZ');
Route::get('/name/desc',[StoreController::class, 'sortNameZToA'])->name('products.sortNameZToA');
Route::get('/price/asc',[StoreController::class, 'sortPriceLowToHigh'])->name('products.sortPriceLowToHigh');
Route::get('/price/desc',[StoreController::class, 'sortPriceHighToLow'])->name('products.sortPriceHighToLow');
Route::get('/category/{product_category}',[StoreController::class, 'sortByCategoryAll'])->name('products.categoryAll');
Route::get('/category/{product_category}/{sortBy}/{order}',[StoreController::class, 'sortByCategorySort'])->name('products.categorySort');
Route::get('/search',[StoreController::class, 'showSearch'])->name('products.showSearch');
Route::get('/search/{current_search}/{sortBy}/{order}',[StoreController::class, 'searchSort'])->name('products.searchSort');

//Order
Route::post('loadOrderDetails',[OrdersController::class, 'loadOrderDetails']);

//Accounts
Route::post('loadUserDetails',[AccountsController::class, 'loadUserDetails']);
Route::post('checkUserEmail',[AccountsController::class, 'checkUserEmail']);

//Ajax Calls for Admin to retrieve data from database
Route::post('loadEditInfo',[AjaxController::class, 'loadEditInfo']);
Route::post('loadDeleteInfo',[AjaxController::class, 'loadDeleteInfo']);
Route::post('loadSearchResults',[AjaxController::class, 'loadSearchResults']);
Route::post('loadCategoryEditInfo',[AjaxController::class, 'loadCategoryEditInfo']);
Route::post('loadCategoryDeleteInfo',[AjaxController::class, 'loadCategoryDeleteInfo']);
Route::post('checkProductName',[AjaxController::class, 'checkProductName']);
Route::post('checkProductCategory',[AjaxController::class, 'checkProductCategory']);


