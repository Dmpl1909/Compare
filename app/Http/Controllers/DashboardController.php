<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Offer;
use App\Models\PriceAlert;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $stats = [
            'produtos' => Product::count(),
            'ofertas' => Offer::count(),
            'utilizadores' => User::count(),
            'favoritos' => Favorite::count(),
            'alertas' => PriceAlert::count(),
        ];

        $roleMessage = match ($user->role) {
            'admin' => 'Admin: podes gerir utilizadores, fontes e ofertas.',
            'gestor' => 'Gestor: acompanha catálogo, ofertas e alertas.',
            default => 'Cliente: acompanha favoritos e alertas de preço.',
        };

        return view('dashboard.index', [
            'user' => $user,
            'stats' => $stats,
            'roleMessage' => $roleMessage,
        ]);
    }
}
