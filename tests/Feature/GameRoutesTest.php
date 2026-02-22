<?php

namespace Tests\Feature;

use Tests\TestCase;

class GameRoutesTest extends TestCase
{
    /**
     * Teste que a rota /jogos retorna status 200
     */
    public function test_games_route_returns_200(): void
    {
        $response = $this->get('/jogos');

        $response->assertStatus(200);
    }

    /**
     * Teste que a rota /api/games/deals retorna JSON
     */
    public function test_games_api_deals_route_returns_json(): void
    {
        $response = $this->get('/api/games/deals');

        $response->assertHeader('content-type', 'application/json');
    }

    /**
     * Teste que a rota /api/games/stores retorna JSON
     */
    public function test_games_api_stores_route_returns_json(): void
    {
        $response = $this->get('/api/games/stores');

        $response->assertHeader('content-type', 'application/json');
    }

    /**
     * Teste que a rota games tem o nome correto
     */
    public function test_games_route_has_correct_name(): void
    {
        $url = route('games.index');

        $this->assertStringEndsWith('/jogos', $url);
    }

    /**
     * Teste que a rota API deals tem o nome correto
     */
    public function test_games_api_deals_route_has_correct_name(): void
    {
        $url = route('api.games.deals');

        $this->assertStringEndsWith('/api/games/deals', $url);
    }

    /**
     * Teste que a rota API stores tem o nome correto
     */
    public function test_games_api_stores_route_has_correct_name(): void
    {
        $url = route('api.games.stores');

        $this->assertStringEndsWith('/api/games/stores', $url);
    }

    /**
     * Teste que não retorna 404 para rota de jogos
     */
    public function test_games_route_not_found_returns_404(): void
    {
        $response = $this->get('/jogos-inexistente');

        $response->assertRedirect(route('home'));
    }

    /**
     * Teste com parâmetro page na rota
     */
    public function test_games_api_deals_accepts_page_parameter(): void
    {
        $response = $this->get('/api/games/deals?page=2');

        $response->assertStatus(200);
    }

    /**
     * Teste com parâmetro sortBy na rota
     */
    public function test_games_api_deals_accepts_sortby_parameter(): void
    {
        $response = $this->get('/api/games/deals?sortBy=Price');

        $response->assertStatus(200);
    }

    /**
     * Teste com parâmetro pageSize na rota
     */
    public function test_games_api_deals_accepts_pagesize_parameter(): void
    {
        $response = $this->get('/api/games/deals?pageSize=30');

        $response->assertStatus(200);
    }

    /**
     * Teste com múltiplos parâmetros
     */
    public function test_games_api_deals_accepts_multiple_parameters(): void
    {
        $response = $this->get('/api/games/deals?page=1&sortBy=Savings&pageSize=20&onSale=1');

        $response->assertStatus(200);
    }

    /**
     * Teste que retorna resposta mesmo com parâmetros inválidos
     */
    public function test_games_api_deals_with_invalid_parameters(): void
    {
        $response = $this->get('/api/games/deals?page=abc&sortBy=InvalidSort&pageSize=999');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/json');
    }
}
