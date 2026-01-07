## Comparador de Preços (Laravel 12)

Aplicação web para comparar preços de produtos em várias fontes, guardar favoritos e definir alertas. Interface em Blade (PT-PT), base de dados MySQL.

### Funcionalidades
- Pesquisa por nome/marca/SKU.
- Vista de detalhe com quadro de ofertas e histórico de preços.
- Autenticação simples (registo/login/logout).
- Favoritos por utilizador.
- Alertas de preço com valor alvo.
- Dados de demonstração para exploração rápida.

### Stack
- Laravel 12, Blade, Tailwind (via Vite).
- MySQL (pode usar SQLite em desenvolvimento se preferir).

### Setup rápido
1) Copiar `.env.example` para `.env` e configurar `DB_*` para MySQL.
2) `composer install`
3) `php artisan key:generate`
4) `php artisan migrate --seed`
5) `npm install && npm run dev` (ou `npm run build` em produção).
6) `php artisan serve`

Credenciais seed: `demo@example.com` / `password`.

### Estrutura principal
- Catálogo: Products, Sources, Offers, PriceHistories.
- Utilizador: Favorites, PriceAlerts.
- UI: rotas em `routes/web.php`, vistas em `resources/views/products` e `resources/views/auth`.

### Próximos passos sugeridos
- Integrar APIs reais ou scraping para atualizar `offers` e `price_histories` via jobs agendados.
- Enviar alertas (email/SMS) quando o preço ficar abaixo do alvo.
- Adicionar filtros avançados (categoria, intervalo de preços) e gráficos de histórico.
