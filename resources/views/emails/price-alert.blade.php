<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alerta de Preço</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px 10px 0 0;
            margin: -30px -30px 20px -30px;
        }
        .game-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .price-info {
            text-align: center;
            margin: 20px 0;
        }
        .current-price {
            font-size: 2em;
            font-weight: bold;
            color: #28a745;
        }
        .target-price {
            font-size: 1.2em;
            color: #666;
            margin-top: 5px;
        }
        .savings {
            font-size: 1.1em;
            color: #dc3545;
            font-weight: bold;
            margin-top: 10px;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎮 Alerta de Preço Ativado!</h1>
            <p>O jogo que estava a vigiar baixou de preço!</p>
        </div>

        <div class="game-info">
            <h2>{{ $priceAlert->product->name }}</h2>
            <p><strong>Desenvolvedor:</strong> {{ $priceAlert->product->developer ?? 'N/A' }}</p>
            <p><strong>Género:</strong> {{ $priceAlert->product->genre ?? 'N/A' }}</p>
        </div>

        <div class="price-info">
            <div class="current-price">
                €{{ number_format($currentPrice, 2, ',', '.') }}
            </div>
            <div class="target-price">
                Preço alvo: €{{ number_format($priceAlert->target_price, 2, ',', '.') }}
            </div>
            @if($currentPrice < $priceAlert->target_price)
                <div class="savings">
                    💰 Poupança: €{{ number_format($priceAlert->target_price - $currentPrice, 2, ',', '.') }}
                </div>
            @endif
        </div>

        <div style="text-align: center;">
            <a href="{{ route('products.show', $priceAlert->product) }}" class="btn">
                Ver Produto
            </a>
        </div>

        <div class="footer">
            <p>Este email foi enviado porque configurou um alerta de preço para este produto.</p>
            <p>Se não deseja mais receber estas notificações, pode desativar o alerta na sua área de utilizador.</p>
            <p>&copy; 2026 Compare - Preços de Jogos</p>
        </div>
    </div>
</body>
</html>