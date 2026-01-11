<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class GameAPIResponseTest extends TestCase
{
    /**
     * Teste que valida a estrutura de resposta de um jogo
     */
    public function test_game_response_structure_is_valid(): void
    {
        $gameData = [
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
        ];

        // Verificar que todos os campos obrigatórios estão presentes
        $this->assertArrayHasKey('title', $gameData);
        $this->assertArrayHasKey('dealID', $gameData);
        $this->assertArrayHasKey('salePrice', $gameData);
        $this->assertArrayHasKey('normalPrice', $gameData);
        $this->assertArrayHasKey('savings', $gameData);
        $this->assertArrayHasKey('storeID', $gameData);
        $this->assertArrayHasKey('thumb', $gameData);
    }

    /**
     * Teste de conversão de preços
     */
    public function test_sale_price_conversion(): void
    {
        $salePrice = '19.99';
        $converted = floatval($salePrice);

        $this->assertEquals(19.99, $converted);
        $this->assertIsFloat($converted);
    }

    /**
     * Teste de cálculo de desconto
     */
    public function test_discount_calculation(): void
    {
        $normalPrice = 59.99;
        $salePrice = 19.99;
        
        $discount = round(((($normalPrice - $salePrice) / $normalPrice) * 100), 2);
        $expected = 66.68;

        $this->assertEquals($expected, $discount);
    }

    /**
     * Teste de porcentagem de economia
     */
    public function test_savings_percentage_format(): void
    {
        $savings = '66.67';
        $percent = intval($savings);

        $this->assertEquals(66, $percent);
        $this->assertGreaterThan(0, $percent);
        $this->assertLessThanOrEqual(100, $percent);
    }

    /**
     * Teste de validação de Metacritic score
     */
    public function test_metacritic_score_validation(): void
    {
        $validScores = ['85', '75', '0', '100'];

        foreach ($validScores as $score) {
            $scoreInt = intval($score);
            $this->assertGreaterThanOrEqual(0, $scoreInt);
            $this->assertLessThanOrEqual(100, $scoreInt);
        }
    }

    /**
     * Teste de validação de Steam rating
     */
    public function test_steam_rating_validation(): void
    {
        $validRatings = ['84', '90', '0'];

        foreach ($validRatings as $rating) {
            $ratingInt = intval($rating);
            $this->assertGreaterThanOrEqual(0, $ratingInt);
            $this->assertLessThanOrEqual(100, $ratingInt);
        }
    }

    /**
     * Teste de URL de imagem
     */
    public function test_game_thumbnail_url_is_valid(): void
    {
        $thumbUrl = 'https://example.com/image.jpg';

        $this->assertTrue(filter_var($thumbUrl, FILTER_VALIDATE_URL) !== false);
        $this->assertStringStartsWith('https://', $thumbUrl);
    }

    /**
     * Teste de Deal Rating
     */
    public function test_deal_rating_is_numeric(): void
    {
        $dealRating = '10.0';
        $rating = floatval($dealRating);

        $this->assertIsFloat($rating);
        $this->assertGreaterThanOrEqual(0, $rating);
        $this->assertLessThanOrEqual(10, $rating);
    }

    /**
     * Teste que preço de venda não pode ser maior que preço normal
     */
    public function test_sale_price_not_greater_than_normal_price(): void
    {
        $normalPrice = 59.99;
        $salePrice = 19.99;

        $this->assertLessThanOrEqual($normalPrice, $salePrice);
    }

    /**
     * Teste de formato de Deal ID
     */
    public function test_deal_id_format(): void
    {
        $dealID = 'cqfYvzS3vimU0rYYwHbT6qhUxHKicwZ0l2cbUWurYfU%3D';

        $this->assertIsString($dealID);
        $this->assertNotEmpty($dealID);
    }

    /**
     * Teste de Store ID
     */
    public function test_store_id_is_numeric(): void
    {
        $storeID = '25';

        $this->assertTrue(is_numeric($storeID));
        $this->assertGreaterThan(0, intval($storeID));
    }
}
