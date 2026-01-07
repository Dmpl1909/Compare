<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class UserFavoritesController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $favorites = $user->favorites()
            ->with(['product.offers.source'])
            ->latest()
            ->paginate(12);

        return view('favorites.index', [
            'favorites' => $favorites,
        ]);
    }
}
