<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GameController extends Controller
{
    public function index()
    {
        return view('games.index');
    }

    public function getDeals(Request $request)
    {
        try {
            $page = $request->get('page', 0);
            $pageSize = $request->get('pageSize', 60);
            $sortBy = $request->get('sortBy', 'Recent');
            $onSale = $request->get('onSale', 1);

            \Log::info('Requisitando jogos da API CheapShark', [
                'page' => $page,
                'pageSize' => $pageSize,
                'sortBy' => $sortBy
            ]);

            $response = Http::withOptions([
                'verify' => false, // Desabilitar verificação SSL temporariamente
            ])->timeout(30)->get('https://www.cheapshark.com/api/1.0/deals', [
                'pageNumber' => $page,
                'pageSize' => $pageSize,
                'sortBy' => $sortBy,
                'onSale' => $onSale
            ]);

            if ($response->successful()) {
                $data = $response->json();
                \Log::info('Jogos recebidos da API', ['count' => count($data)]);
                return response()->json($data);
            }

            \Log::error('Falha ao buscar jogos', ['status' => $response->status()]);
            return response()->json(['error' => 'Failed to fetch deals', 'status' => $response->status()], 500);
        } catch (\Exception $e) {
            \Log::error('Exceção ao buscar jogos', ['message' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getStores()
    {
        try {
            $response = Http::withOptions([
                'verify' => false,
            ])->timeout(30)->get('https://www.cheapshark.com/api/1.0/stores');

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json(['error' => 'Failed to fetch stores'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
