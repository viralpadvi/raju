<?php

use App\Http\Controllers\Api\Admin\AdCampaignController;
use App\Http\Controllers\Api\Admin\AdPlacementController;
use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\BranchController;
use App\Http\Controllers\Api\Admin\BrandController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\ProductController;
use App\Http\Controllers\Api\Admin\PurchaseController;
use App\Http\Controllers\Api\Admin\RegisterController;
use App\Http\Controllers\Api\Admin\ReportController;
use App\Http\Controllers\Api\Admin\SaleController;
use App\Http\Controllers\Api\Admin\ProjectController;
use App\Http\Controllers\Api\Admin\SettingController;
use App\Http\Controllers\Api\Admin\SupplierController;
use App\Http\Controllers\Api\Admin\OrderController;
use App\Http\Controllers\Api\Admin\NotificationController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('api.admin.')->group(function () {
    Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
        Route::post('auth/refresh', [AuthController::class, 'refresh'])->name('auth.refresh');
        Route::get('auth/profile', [AuthController::class, 'profile'])->name('auth.profile');

        Route::middleware(['admin.api', 'abilities:admin'])->group(function () {
            Route::get('dashboard/summary', [DashboardController::class, 'summary'])->name('dashboard.summary');
            Route::get('dashboard/recent-sales', [DashboardController::class, 'recentSales'])->name('dashboard.recent-sales');
            Route::get('dashboard/low-stock', [DashboardController::class, 'lowStock'])->name('dashboard.low-stock');

            Route::apiResource('catalog/brands', BrandController::class);
            Route::apiResource('catalog/categories', CategoryController::class);
            Route::apiResource('catalog/products', ProductController::class);

            Route::apiResource('inventory/branches', BranchController::class);
            Route::apiResource('inventory/registers', RegisterController::class);
            Route::apiResource('inventory/suppliers', SupplierController::class);
            Route::apiResource('inventory/purchases', PurchaseController::class);
            Route::post('inventory/purchases/{purchase}/receive', [PurchaseController::class, 'receive'])
                ->name('inventory.purchases.receive');
            Route::post('inventory/purchases/{purchase}/cancel', [PurchaseController::class, 'cancel'])
                ->name('inventory.purchases.cancel');

            Route::apiResource('pos/sales', SaleController::class)->only(['index', 'show', 'store']);

            Route::apiResource('advertising/campaigns', AdCampaignController::class);
            Route::apiResource('advertising/placements', AdPlacementController::class);

            Route::apiResource('projects', ProjectController::class);

            Route::get('reports/summary', [ReportController::class, 'summary'])->name('reports.summary');
            Route::get('reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
            Route::get('reports/export/{type}', [ReportController::class, 'export'])->name('reports.export');

            Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
            Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
            Route::post('settings/backup', [SettingController::class, 'createBackup'])->name('settings.backup');
            Route::post('settings/clear-cache', [SettingController::class, 'clearCache'])->name('settings.clear-cache');
            Route::post('settings/update-system', [SettingController::class, 'updateSystem'])->name('settings.update-system');
            Route::post('settings/reset', [SettingController::class, 'reset'])->name('settings.reset');

            // Delivery routes
            Route::get('delivery/orders', [OrderController::class, 'index'])->name('delivery.orders.index');
            Route::get('delivery/orders/{order}', [OrderController::class, 'show'])->name('delivery.orders.show');
            Route::post('delivery/orders/{order}/accept', [OrderController::class, 'accept'])->name('delivery.orders.accept');
            Route::post('delivery/orders/{order}/pickup', [OrderController::class, 'pickup'])->name('delivery.orders.pickup');
            Route::post('delivery/orders/{order}/deliver', [OrderController::class, 'deliver'])->name('delivery.orders.deliver');
            Route::put('delivery/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('delivery.orders.update-status');
            Route::post('delivery/orders/{order}/assign', [OrderController::class, 'assign'])->name('delivery.orders.assign');

            Route::get('delivery/notifications', [NotificationController::class, 'index'])->name('delivery.notifications.index');
            Route::get('delivery/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('delivery.notifications.unread-count');
            Route::put('delivery/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('delivery.notifications.mark-read');
            Route::post('delivery/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('delivery.notifications.mark-all-read');
            Route::delete('delivery/notifications/{notification}', [NotificationController::class, 'destroy'])->name('delivery.notifications.destroy');
        });
    });
});
