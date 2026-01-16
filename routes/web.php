<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ManageProductController;
use App\Http\Controllers\ManageUserController;
use App\Http\Controllers\PriceAlertController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserFavoritesController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'home'])->name('home');
Route::get('/jogos', [ProductController::class, 'catalog'])->name('products.catalog');
Route::get('/produtos/{product}', [ProductController::class, 'show'])->name('products.show');

// Contato
Route::get('/contato', [ContactController::class, 'index'])->name('contact');
Route::post('/contato', [ContactController::class, 'send'])->name('contact.send');

// Rotas para jogos em promoção (CheapShark API)
Route::get('/jogos/promocoes', [GameController::class, 'index'])->name('games.deals');
Route::get('/api/games/deals', [GameController::class, 'getDeals'])->name('api.games.deals');
Route::get('/api/games/stores', [GameController::class, 'getStores'])->name('api.games.stores');

Route::middleware('guest')->group(function () {
    Route::get('/registar', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/registar', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::middleware('role:gestor,admin')->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/favoritos', [UserFavoritesController::class, 'index'])->name('favorites.index');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/favorites/{product}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{product}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
    Route::post('/alerts/{product}', [PriceAlertController::class, 'store'])->name('alerts.store');
    Route::delete('/alerts/{product}', [PriceAlertController::class, 'destroy'])->name('alerts.destroy');
});

// Gestão (gestor e admin)
Route::middleware(['auth', 'role:gestor,admin'])->prefix('gestao')->name('manage.')->group(function () {
    // Gestão de jogos (gestor e admin podem adicionar/remover)
    Route::get('/produtos', [ManageProductController::class, 'index'])->name('products.index');
    Route::get('/produtos/criar', [ManageProductController::class, 'create'])->name('products.create');
    Route::post('/produtos', [ManageProductController::class, 'store'])->name('products.store');
    Route::get('/produtos/{product}/editar', [ManageProductController::class, 'edit'])->name('products.edit');
    Route::put('/produtos/{product}', [ManageProductController::class, 'update'])->name('products.update');
    Route::delete('/produtos/{product}', [ManageProductController::class, 'destroy'])->name('products.destroy');
    
    // Gestão de utilizadores (gestor e admin podem visualizar, apenas admin pode alterar permissões)
    Route::get('/utilizadores', [ManageUserController::class, 'index'])->name('users.index');
    Route::put('/utilizadores/{user}', [ManageUserController::class, 'update'])->name('users.update');
    Route::delete('/utilizadores/{user}', [ManageUserController::class, 'destroy'])->name('users.destroy');
});
