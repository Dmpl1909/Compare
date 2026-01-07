<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ManageProductController;
use App\Http\Controllers\PriceAlertController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserFavoritesController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/produtos/{product}', [ProductController::class, 'show'])->name('products.show');

Route::middleware('guest')->group(function () {
    Route::get('/registar', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/registar', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/favoritos', [UserFavoritesController::class, 'index'])->name('favorites.index');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/favorites/{product}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{product}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
    Route::post('/alerts/{product}', [PriceAlertController::class, 'store'])->name('alerts.store');
    Route::delete('/alerts/{product}', [PriceAlertController::class, 'destroy'])->name('alerts.destroy');
});

Route::middleware(['auth', 'role:gestor,admin'])->prefix('gestao')->name('manage.')->group(function () {
    Route::get('/produtos', [ManageProductController::class, 'index'])->name('products.index');
    Route::get('/produtos/criar', [ManageProductController::class, 'create'])->name('products.create');
    Route::post('/produtos', [ManageProductController::class, 'store'])->name('products.store');
    Route::delete('/produtos/{product}', [ManageProductController::class, 'destroy'])->name('products.destroy');
});
