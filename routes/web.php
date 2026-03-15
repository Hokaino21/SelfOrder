<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return redirect('/menu');
});

// Menu Routes
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/{id}', [MenuController::class, 'show'])->name('menu.show');

// Order Routes
Route::get('/order/create', [OrderController::class, 'create'])->name('order.create');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('/order/{id}/receipt', [OrderController::class, 'receipt'])->name('order.receipt');
Route::get('/order/{id}/payment', [OrderController::class, 'payment'])->name('order.payment');
Route::post('/order/{id}/pay', [OrderController::class, 'processPayment'])->name('order.processPayment');
Route::get('/order/track/{orderNumber}', [OrderController::class, 'track'])->name('order.track');
Route::get('/order/{id}/status', [OrderController::class, 'status'])->name('order.status');
Route::get('/order/history', [OrderController::class, 'history'])->name('order.history');

// Admin Routes
Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'authenticate'])->name('admin.authenticate');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/dashboard/data', [AdminController::class, 'getDashboardData'])->name('admin.dashboardData');
Route::post('/admin/order/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.updateStatus');
Route::post('/admin/order/{id}/delete', [AdminController::class, 'deleteOrder'])->name('admin.deleteOrder');
