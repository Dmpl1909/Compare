<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GameControllerTest extends TestCase
{
    /**
     * Teste da rota index para exibir página de jogos
     */
    public function test_games_index_page_loads(): void
    {
        $response = $this->get('/jogos');

        $response->assertStatus(200);
        $response->assertViewIs('games.index');
    }

    /**
     * Teste da API de deals - sucesso
     */
    public function test_api_games_deals_returns_successful_response(): void
    {
        Http::fake([
            'https://www.cheapshark.com/api/1.0/deals*' => Http::response([
                [
                    'internalName' => 'TOTWAR3K',
                    'title' => 'Total War: THREE KINGDOMS',
                    'dealID' => 'test-deal-id',
                    'storeID' => '25',
                    'salePrice' => '19.99',
                    'normalPrice' => '59.99',
                    'savings' => '66.67',
                    'metacriticScore' => '85',
                    'steamRatingPercent' => '84',
                    'steamRatingCount' => '17010',
                    'thumb' => 'https://example.com/image.jpg',
                    'dealRating' => '10.0'
                ]
            ], 200),
        ]);

        $response = $this->get('/api/games/deals');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([
            'title' => 'Total War: THREE KINGDOMS',
            'salePrice' => '19.99'
        ]);
    }

    /**
     * Teste da API de deals com parâmetros personalizados
     */
    public function test_api_games_deals_with_custom_parameters(): void
    {
        Http::fake([
            'https://www.cheapshark.com/api/1.0/deals*' => Http::response([], 200),
        ]);

        $response = $this->get('/api/games/deals?page=1&pageSize=20&sortBy=Price');

        $response->assertStatus(200);
        $response->assertJson([]);
    }

    /**
     * Teste da API de stores
     */
    public function test_api_games_stores_returns_stores(): void
    {
        Http::fake([
            'https://www.cheapshark.com/api/1.0/stores' => Http::response([
                [
                    'storeID' => '1',
                    'storeName' => 'Steam',
                    'images' => ['logo' => '/logo.png']
                ],
                [
                    'storeID' => '2',
                    'storeName' => 'GOG',
                    'images' => ['logo' => '/logo2.png']
                ]
            ], 200),
        ]);

        $response = $this->get('/api/games/stores');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment(['storeName' => 'Steam']);
        $response->assertJsonFragment(['storeName' => 'GOG']);
    }

    /**
     * Teste de erro quando API de deals falha
     */
    public function test_api_games_deals_handles_api_error(): void
    {
        Http::fake([
            'https://www.cheapshark.com/api/1.0/deals*' => Http::response([], 500),
        ]);

        $response = $this->get('/api/games/deals');

        $response->assertStatus(500);
        $response->assertJsonFragment(['error' => 'Failed to fetch deals']);
    }

    /**
     * Teste de erro quando API de stores falha
     */
    public function test_api_games_stores_handles_api_error(): void
    {
        Http::fake([
            'https://www.cheapshark.com/api/1.0/stores' => Http::response([], 500),
        ]);

        $response = $this->get('/api/games/stores');

        $response->assertStatus(500);
        $response->assertJsonFragment(['error' => 'Failed to fetch stores']);
    }

    /**
     * Teste de timeout na requisição
     */
    public function test_api_games_deals_handles_timeout(): void
    {
        Http::fake([
            'https://www.cheapshark.com/api/1.0/deals*' => Http::response([], 500),
        ]);

        $response = $this->get('/api/games/deals');

        $response->assertStatus(500);
        $response->assertJsonStructure(['error']);
    }

    /**
     * Teste que a resposta contém estrutura JSON esperada
     */
    public function test_api_games_deals_json_structure(): void
    {
        Http::fake([
            'https://www.cheapshark.com/api/1.0/deals*' => Http::response([
                [
                    'internalName' => 'GAME1',
                    'title' => 'Game Title',
                    'dealID' => 'deal-123',
                    'storeID' => '1',
                    'salePrice' => '9.99',
                    'normalPrice' => '29.99',
                    'savings' => '66.67',
                    'metacriticScore' => '75',
                    'steamRatingPercent' => '80',
                    'steamRatingCount' => '1000',
                    'dealRating' => '8.5',
                    'thumb' => 'https://example.com/thumb.jpg'
                ]
            ], 200),
        ]);

        $response = $this->get('/api/games/deals');

        $response->assertJsonStructure([
            '*' => [
                'internalName',
                'title',
                'dealID',
                'storeID',
                'salePrice',
                'normalPrice',
                'savings',
                'metacriticScore',
                'steamRatingPercent',
                'steamRatingCount',
                'dealRating',
                'thumb'
            ]
        ]);
    }

    /**
     * Teste com múltiplos jogos
     */
    public function test_api_games_deals_returns_multiple_games(): void
    {
        Http::fake([
            'https://www.cheapshark.com/api/1.0/deals*' => Http::response([
                [
                    'title' => 'Game 1',
                    'dealID' => 'deal-1',
                    'salePrice' => '9.99',
                    'normalPrice' => '29.99',
                    'savings' => '66.67',
                    'storeID' => '1',
                    'metacriticScore' => '75',
                    'steamRatingPercent' => '80',
                    'steamRatingCount' => '1000',
                    'dealRating' => '8.5',
                    'thumb' => 'https://example.com/1.jpg',
                    'internalName' => 'GAME1'
                ],
                [
                    'title' => 'Game 2',
                    'dealID' => 'deal-2',
                    'salePrice' => '14.99',
                    'normalPrice' => '49.99',
                    'savings' => '70.00',
                    'storeID' => '2',
                    'metacriticScore' => '85',
                    'steamRatingPercent' => '90',
                    'steamRatingCount' => '5000',
                    'dealRating' => '9.0',
                    'thumb' => 'https://example.com/2.jpg',
                    'internalName' => 'GAME2'
                ],
                [
                    'title' => 'Game 3',
                    'dealID' => 'deal-3',
                    'salePrice' => '4.99',
                    'normalPrice' => '19.99',
                    'savings' => '75.00',
                    'storeID' => '3',
                    'metacriticScore' => '70',
                    'steamRatingPercent' => '75',
                    'steamRatingCount' => '2000',
                    'dealRating' => '7.5',
                    'thumb' => 'https://example.com/3.jpg',
                    'internalName' => 'GAME3'
                ]
            ], 200),
        ]);

        $response = $this->get('/api/games/deals');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
        $response->assertJsonFragment(['title' => 'Game 1']);
        $response->assertJsonFragment(['title' => 'Game 2']);
        $response->assertJsonFragment(['title' => 'Game 3']);
    }

    /**
     * Teste da rota games.index nomeada
     */
    public function test_games_route_name_is_correct(): void
    {
        $response = $this->get(route('games.index'));

        $response->assertStatus(200);
    }

    /**
     * Teste que a view contém elementos esperados
     */
    public function test_games_view_contains_expected_elements(): void
    {
        $response = $this->get('/jogos');

        $response->assertSee('Jogos em Promoção');
        $response->assertSee('Ofertas em tempo real do CheapShark');
    }

    /**
     * Teste com página específica
     */
    public function test_api_games_deals_page_parameter_is_passed(): void
    {
        Http::fake([
            'https://www.cheapshark.com/api/1.0/deals*' => Http::response([], 200),
        ]);

        $this->get('/api/games/deals?page=5');

        Http::assertSent(function ($request) {
            return $request->url() === 'https://www.cheapshark.com/api/1.0/deals?pageNumber=5&pageSize=60&sortBy=Recent&onSale=1';
        });
    }

    /**
     * Teste com tipo de ordenação personalizado
     */
    public function test_api_games_deals_sort_parameter_is_passed(): void
    {
        Http::fake([
            'https://www.cheapshark.com/api/1.0/deals*' => Http::response([], 200),
        ]);

        $this->get('/api/games/deals?sortBy=Savings');

        Http::assertSent(function ($request) {
            return strpos($request->url(), 'sortBy=Savings') !== false;
        });
    }
}
