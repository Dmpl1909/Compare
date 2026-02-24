@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold tracking-tight">Jogos em Promoção</h1>
            <p class="mt-1 text-gray-500">Ofertas em tempo real do CheapShark</p>
        </div>

        <div class="flex gap-2">
            <select id="sortBy" class="rounded-2xl border border-teal-200 bg-gradient-to-r from-teal-50 to-cyan-50 px-4 py-2 text-sm text-slate-900 shadow-lg shadow-teal-900/10 focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500/20" style="color: #0f172a;">
                <option value="Recent">Mais Recentes</option>
                <option value="Deal Rating">Melhor Avaliação</option>
                <option value="Price">Menor Preço</option>
                <option value="Savings">Maior Desconto</option>
                <option value="Metacritic">Metacritic</option>
            </select>
            <button id="refreshBtn" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                Atualizar
            </button>
        </div>
    </div>

    <div id="loadingSpinner" class="flex items-center justify-center py-20">
        <div class="h-12 w-12 animate-spin rounded-full border-4 border-gray-300 border-t-indigo-600"></div>
    </div>

    <div id="gamesGrid" class="hidden grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
        <!-- Os jogos serão carregados aqui via JavaScript -->
    </div>

    <div id="loadMoreContainer" class="hidden mt-8 text-center">
        <button id="loadMoreBtn" class="rounded-2xl border border-purple-200 bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-3 font-semibold text-slate-900 shadow-lg shadow-purple-900/10 transition hover:border-purple-400 hover:text-purple-700" style="color: #0f172a;">
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
    card.className = 'group relative overflow-hidden rounded-3xl border border-cyan-500/20 bg-gradient-to-br from-slate-950 via-sky-950 to-teal-950 p-4 sm:p-5 transition hover:-translate-y-0.5 hover:border-cyan-400/40 hover:shadow-2xl hover:shadow-cyan-900/30';
    
    const savings = Math.round(game.savings);
    const normalPrice = parseFloat(game.normalPrice);
    const salePrice = parseFloat(game.salePrice);
    const storeName = stores[game.storeID]?.storeName || 'Loja Desconhecida';
    const storeImage = stores[game.storeID]?.images?.logo || '';

    card.innerHTML = `
        <div class="relative mb-5 aspect-video overflow-hidden rounded-2xl bg-slate-900">
            <img src="${game.thumb}" alt="${game.title}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105" onerror="this.src='https://via.placeholder.com/600x338?text=${encodeURIComponent(game.title)}'">
            ${savings > 0 ? `<span class="absolute right-3 top-3 shrink-0 rounded-lg bg-emerald-500 px-2.5 py-1 text-xs font-bold text-white shadow">-${savings}%</span>` : ''}
        </div>
        <div class="space-y-4 text-slate-100">
            <h3 class="line-clamp-2 text-2xl font-bold leading-tight">${game.title}</h3>

            <div class="h-px bg-white/10"></div>

            <div class="flex items-end justify-between gap-3">
                <div>
                    <p class="text-sm text-slate-400">Melhor preço</p>
                    <p class="text-4xl font-extrabold leading-none text-emerald-400">€${salePrice.toFixed(2)}</p>
                    <div class="mt-1 flex items-center gap-2 text-base text-slate-400">
                        <span>em ${storeName}</span>
                        ${storeImage ? `<img src="https://www.cheapshark.com${storeImage}" alt="${storeName}" class="h-4" onerror="this.style.display='none'">` : ''}
                    </div>
                    ${normalPrice > salePrice ? `<p class="mt-1 text-sm text-slate-500 line-through">€${normalPrice.toFixed(2)}</p>` : ''}
                </div>

                <a href="https://www.cheapshark.com/redirect?dealID=${game.dealID}" target="_blank" class="flex h-14 w-14 items-center justify-center rounded-full bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-lg shadow-emerald-900/40 transition hover:scale-105 hover:from-emerald-400 hover:to-teal-400" aria-label="Ver oferta de ${game.title}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 6l6 6-6 6" />
                    </svg>
                </a>
            </div>
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
