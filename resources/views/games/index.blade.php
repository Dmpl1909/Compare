@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold tracking-tight">Jogos em Promoção</h1>
            <p class="mt-1 text-gray-500">Ofertas em tempo real do CheapShark</p>
        </div>

        <div class="flex gap-2">
            <select id="sortBy" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="Recent">Mais Recentes</option>
                <option value="Deal Rating">Melhor Avaliação</option>
                <option value="Price">Menor Preço</option>
                <option value="Savings">Maior Desconto</option>
                <option value="Metacritic">Metacritic</option>
            </select>
            <button id="refreshBtn" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold transition hover:bg-indigo-700">
                Atualizar
            </button>
        </div>
    </div>

    <div id="loadingSpinner" class="flex items-center justify-center py-20">
        <div class="h-12 w-12 animate-spin rounded-full border-4 border-gray-300 border-t-indigo-600"></div>
    </div>

    <div id="gamesGrid" class="hidden grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        <!-- Os jogos serão carregados aqui via JavaScript -->
    </div>

    <div id="loadMoreContainer" class="hidden mt-8 text-center">
        <button id="loadMoreBtn" class="rounded-lg bg-gray-100 px-6 py-3 font-semibold transition hover:bg-gray-200">
            Carregar Mais
        </button>
    </div>
</div>

<script>
let currentPage = 0;
let currentSort = 'Recent';
let stores = {};

// Carregar lojas
async function loadStores() {
    try {
        const response = await fetch('/api/games/stores');
        const data = await response.json();
        data.forEach(store => {
            stores[store.storeID] = store;
        });
    } catch (error) {
        console.error('Erro ao carregar lojas:', error);
    }
}

// Carregar jogos
async function loadGames(page = 0, append = false) {
    const loadingSpinner = document.getElementById('loadingSpinner');
    const gamesGrid = document.getElementById('gamesGrid');
    const loadMoreContainer = document.getElementById('loadMoreContainer');

    if (!append) {
        loadingSpinner.classList.remove('hidden');
        gamesGrid.classList.add('hidden');
    }

    try {
        console.log('Carregando jogos, página:', page, 'ordenação:', currentSort);
        const response = await fetch(`/api/games/deals?page=${page}&sortBy=${currentSort}&pageSize=60`);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const games = await response.json();
        console.log('Jogos carregados:', games.length);

        if (games.error) {
            console.error('Erro da API:', games.error);
            alert('Erro ao carregar jogos: ' + games.error);
            loadingSpinner.classList.add('hidden');
            return;
        }

        if (!append) {
            gamesGrid.innerHTML = '';
        }

        if (games.length === 0) {
            gamesGrid.innerHTML = '<div class="col-span-full text-center py-12 text-slate-400">Nenhum jogo encontrado</div>';
            gamesGrid.classList.remove('hidden');
            loadingSpinner.classList.add('hidden');
            return;
        }

        games.forEach(game => {
            const gameCard = createGameCard(game);
            gamesGrid.appendChild(gameCard);
        });

        loadingSpinner.classList.add('hidden');
        gamesGrid.classList.remove('hidden');
        loadMoreContainer.classList.remove('hidden');

    } catch (error) {
        console.error('Erro ao carregar jogos:', error);
        gamesGrid.innerHTML = `<div class="col-span-full text-center py-12 text-red-400">Erro: ${error.message}</div>`;
        gamesGrid.classList.remove('hidden');
        loadingSpinner.classList.add('hidden');
    }
}

// Criar card de jogo
function createGameCard(game) {
    const card = document.createElement('div');
    card.className = 'group relative overflow-hidden rounded-lg border border-gray-200 bg-white transition hover:border-indigo-500 hover:shadow-lg hover:shadow-indigo-500/10';
    
    const savings = Math.round(game.savings);
    const normalPrice = parseFloat(game.normalPrice);
    const salePrice = parseFloat(game.salePrice);
    const storeName = stores[game.storeID]?.storeName || 'Loja Desconhecida';
    const storeImage = stores[game.storeID]?.images?.logo || '';

    card.innerHTML = `
        <div class="aspect-video overflow-hidden bg-gray-100">
            <img src="${game.thumb}" alt="${game.title}" class="h-full w-full object-cover transition group-hover:scale-105" onerror="this.src='https://via.placeholder.com/300x200?text=${encodeURIComponent(game.title)}'">
        </div>
        <div class="p-4">
            <div class="mb-2 flex items-start justify-between gap-2">
                <h3 class="line-clamp-2 text-sm font-semibold leading-tight">${game.title}</h3>
                ${savings > 0 ? `<span class="shrink-0 rounded bg-emerald-600 px-2 py-1 text-xs font-bold text-white">-${savings}%</span>` : ''}
            </div>
            
            <div class="mb-3 flex items-center gap-2 text-xs text-gray-500">
                ${storeImage ? `<img src="https://www.cheapshark.com${storeImage}" alt="${storeName}" class="h-4" onerror="this.style.display='none'">` : ''}
                <span>${storeName}</span>
            </div>

            <div class="flex items-center justify-between">
                <div>
                    ${normalPrice > salePrice ? `<div class="text-xs text-gray-500 line-through">€${normalPrice.toFixed(2)}</div>` : ''}
                    <div class="text-lg font-bold text-emerald-600">€${salePrice.toFixed(2)}</div>
                </div>
                <a href="https://www.cheapshark.com/redirect?dealID=${game.dealID}" target="_blank" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                    Ver Oferta
                </a>
            </div>

            ${game.metacriticScore > 0 ? `
                <div class="mt-3 flex items-center gap-2 text-xs">
                    <span class="text-gray-500">Metacritic:</span>
                    <span class="font-semibold ${game.metacriticScore >= 75 ? 'text-emerald-600' : game.metacriticScore >= 50 ? 'text-yellow-500' : 'text-red-500'}">${game.metacriticScore}</span>
                </div>
            ` : ''}

            ${game.steamRatingPercent > 0 ? `
                <div class="mt-2 flex items-center gap-2 text-xs">
                    <span class="text-gray-500">Steam:</span>
                    <span class="font-semibold text-indigo-600">${game.steamRatingPercent}%</span>
                    <span class="text-gray-400">(${parseInt(game.steamRatingCount).toLocaleString()} avaliações)</span>
                </div>
            ` : ''}
        </div>
    `;

    return card;
}

// Event listeners
document.getElementById('sortBy').addEventListener('change', (e) => {
    currentSort = e.target.value;
    currentPage = 0;
    loadGames(0, false);
});

document.getElementById('refreshBtn').addEventListener('click', () => {
    currentPage = 0;
    loadGames(0, false);
});

document.getElementById('loadMoreBtn').addEventListener('click', () => {
    currentPage++;
    loadGames(currentPage, true);
});

// Auto-atualizar a cada 2 minutos
setInterval(() => {
    loadGames(0, false);
    currentPage = 0;
}, 120000);

// Inicializar
(async () => {
    await loadStores();
    await loadGames(0);
})();
</script>
@endsection
