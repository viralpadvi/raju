<?php

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

// Frontend Routes
Route::get('/', [App\Http\Controllers\Storefront\HomeController::class, 'index'])->name('home');

// Test route for SweetAlert2
Route::get('/test-sweetalert', function () {
    return view('test-sweetalert');
})->name('test.sweetalert');

Route::get('/products', function () {
    return view('frontend.products.index');
})->name('products');

Route::get('/products/{id}', function ($id) {
    return view('frontend.products.show');
})->name('product.show');

// Projects routes
Route::get('/projects', [App\Http\Controllers\Storefront\ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{slug}', [App\Http\Controllers\Storefront\ProjectController::class, 'show'])->name('projects.show');

Route::get('/category/{slug}', function ($slug) {
    return view('frontend.category');
})->name('category');

Route::get('/brands', function () {
    return view('frontend.brands');
})->name('brands');

Route::get('/search', function () {
    return view('frontend.search');
})->name('search');

Route::get('/cart', function () {
    return view('frontend.cart');
})->name('cart');

Route::get('/checkout', function () {
    return view('frontend.checkout');
})->name('checkout');

Route::post('/checkout', function () {
    // Handle checkout processing
    return redirect()->route('checkout.success');
})->name('checkout.process');

Route::get('/checkout/success', function () {
    return view('frontend.checkout-success');
})->name('checkout.success');

Route::get('/deals', function () {
    return view('frontend.deals');
})->name('deals');

Route::get('/about', function () {
    return view('frontend.about');
})->name('about');

Route::get('/contact', function () {
    return view('frontend.contact');
})->name('contact');

// Additional e-commerce routes
Route::get('/wishlist', function () {
    return view('frontend.wishlist');
})->name('wishlist');

Route::get('/compare', function () {
    return view('frontend.compare');
})->name('compare');

Route::get('/account', function () {
    return redirect()->route('customer.dashboard');
})->name('account');

// Customer Authentication Routes
Route::get('/login', [App\Http\Controllers\Auth\CustomerAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\CustomerAuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\CustomerAuthController::class, 'logout'])->name('logout');

Route::get('/register', [App\Http\Controllers\Auth\CustomerAuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\CustomerAuthController::class, 'register']);

Route::get('/forgot-password', [App\Http\Controllers\Auth\CustomerAuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [App\Http\Controllers\Auth\CustomerAuthController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\CustomerAuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [App\Http\Controllers\Auth\CustomerAuthController::class, 'resetPassword'])->name('password.update');

// Customer Dashboard Routes
Route::middleware(['auth:customer'])->group(function () {
    Route::get('/customer/dashboard', [App\Http\Controllers\Customer\AccountController::class, 'dashboard'])->name('customer.dashboard');
    Route::get('/customer/orders', [App\Http\Controllers\Customer\AccountController::class, 'orders'])->name('customer.orders');
    Route::get('/customer/wishlist', [App\Http\Controllers\Customer\AccountController::class, 'wishlist'])->name('customer.wishlist');
    Route::get('/customer/addresses', [App\Http\Controllers\Customer\AccountController::class, 'addresses'])->name('customer.addresses');
    Route::get('/customer/payments', [App\Http\Controllers\Customer\AccountController::class, 'payments'])->name('customer.payments');
    Route::get('/customer/settings', [App\Http\Controllers\Customer\AccountController::class, 'settings'])->name('customer.settings');
});

// Admin Authentication Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');
    
    // Database setup routes (for development)
    Route::get('/setup', function () { return view('admin.setup'); })->name('setup');
    Route::get('/setup-database', [App\Http\Controllers\Admin\DatabaseController::class, 'setupDatabase'])->name('setup-database');
    Route::get('/setup-sqlite', [App\Http\Controllers\Admin\DatabaseController::class, 'setupSQLite'])->name('setup-sqlite');
    Route::get('/create-admin', [App\Http\Controllers\Admin\DatabaseController::class, 'createAdminUser'])->name('create-admin');
    Route::get('/test-db', [App\Http\Controllers\Admin\DatabaseController::class, 'testConnection'])->name('test-db');
    
        // Protected admin routes
        Route::middleware(['auth', 'admin'])->group(function () {
            Route::view('/', 'admin.dashboard')->name('dashboard');
            Route::get('/pos', [App\Http\Controllers\Admin\PosController::class, 'index'])->name('pos');
            Route::get('/pos/search', [App\Http\Controllers\Admin\PosController::class, 'searchProducts'])->name('pos.search');
            Route::get('/pos/barcode', [App\Http\Controllers\Admin\PosController::class, 'getProductByBarcode'])->name('pos.barcode');
            Route::get('/pos/customers/search', [App\Http\Controllers\Admin\PosController::class, 'searchCustomers'])->name('pos.customers.search');
            Route::post('/pos/customers/create', [App\Http\Controllers\Admin\PosController::class, 'createCustomer'])->name('pos.customers.create');
            Route::post('/pos/process', [App\Http\Controllers\Admin\PosController::class, 'processSale'])->name('pos.process');
            
            // Catalog routes
            Route::resource('catalog/brands', App\Http\Controllers\Admin\BrandController::class)->names('catalog.brands');
            Route::resource('catalog/categories', App\Http\Controllers\Admin\CategoryController::class)->names('catalog.categories');
            // Explicit product create route to avoid any routing edge cases
            Route::get('catalog/products/create', [App\Http\Controllers\Admin\ProductController::class, 'create'])
                ->name('catalog.products.create');
            Route::resource('catalog/products', App\Http\Controllers\Admin\ProductController::class)->names('catalog.products');
            
            // Projects routes
            Route::resource('projects', App\Http\Controllers\Admin\ProjectController::class)->names('projects');
            Route::post('projects/{project}/toggle-status', [App\Http\Controllers\Admin\ProjectController::class, 'toggleStatus'])->name('projects.toggle-status');
            Route::post('projects/{project}/toggle-featured', [App\Http\Controllers\Admin\ProjectController::class, 'toggleFeatured'])->name('projects.toggle-featured');
            
            // Inventory routes
            Route::resource('inventory/branches', App\Http\Controllers\Admin\BranchController::class)->names('inventory.branches');
            Route::resource('inventory/purchases', App\Http\Controllers\Admin\PurchaseController::class)->names('inventory.purchases');
            Route::post('inventory/purchases/{purchase}/receive', [App\Http\Controllers\Admin\PurchaseController::class, 'receive'])->name('inventory.purchases.receive');
            Route::post('inventory/purchases/{purchase}/cancel', [App\Http\Controllers\Admin\PurchaseController::class, 'cancel'])->name('inventory.purchases.cancel');
            Route::get('/inventory/transfers', function () { return view('admin.inventory.transfers.index'); })->name('inventory.transfers');
            
            // POS routes
            Route::get('/pos/registers', function () { return view('admin.pos.registers.index'); })->name('pos.registers');
            Route::get('/pos/shifts', function () { return view('admin.pos.shifts.index'); })->name('pos.shifts');
            Route::get('/pos/sales', [App\Http\Controllers\Admin\SaleController::class, 'index'])->name('pos.sales.index');
            Route::get('/pos/sales/{sale}', [App\Http\Controllers\Admin\SaleController::class, 'show'])->name('pos.sales.show');
            Route::get('/pos/sales/{sale}/invoice', [App\Http\Controllers\Admin\InvoiceController::class, 'show'])->name('pos.sales.invoice');
            Route::get('/pos/sales/{sale}/invoice/download', [App\Http\Controllers\Admin\InvoiceController::class, 'download'])->name('pos.sales.invoice.download');
            
            // Advertising routes
            Route::get('/advertising/placements', function () { return view('admin.advertising.placements.index'); })->name('advertising.placements');
            Route::get('/advertising/campaigns', function () { return view('admin.advertising.campaigns.index'); })->name('advertising.campaigns');
            
            // Reports route
            Route::get('/reports', function () { return view('admin.reports.index'); })->name('reports');
            Route::get('/reports/export/{format}', [App\Http\Controllers\Admin\ExportController::class, 'exportReports'])->name('reports.export');
            
            // Settings route
            Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings');
            Route::put('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
            Route::post('/settings/backup', [App\Http\Controllers\Admin\SettingsController::class, 'createBackup'])->name('settings.backup');
            Route::post('/settings/clear-cache', [App\Http\Controllers\Admin\SettingsController::class, 'clearCache'])->name('settings.clear-cache');
            Route::post('/settings/update-system', [App\Http\Controllers\Admin\SettingsController::class, 'updateSystem'])->name('settings.update-system');
            Route::post('/settings/reset', [App\Http\Controllers\Admin\SettingsController::class, 'resetSettings'])->name('settings.reset');
            
            // User & access management
            Route::resource('users', App\Http\Controllers\Admin\UserController::class)->names('users');
            Route::resource('roles', App\Http\Controllers\Admin\RoleController::class)->names('roles');
            Route::resource('permissions', App\Http\Controllers\Admin\PermissionController::class)->except(['show'])->names('permissions');
            Route::resource('customers', App\Http\Controllers\Admin\CustomerController::class)->names('customers');
            
            // Export routes
            Route::get('/catalog/products/export/{format}', [App\Http\Controllers\Admin\ExportController::class, 'exportProducts'])->name('catalog.products.export');
            Route::get('/pos/sales/export/{format}', [App\Http\Controllers\Admin\ExportController::class, 'exportSales'])->name('pos.sales.export');
        });
});

Route::prefix('pos')->group(function () {
    Route::view('/', 'pos.index')->name('pos.index');
});
