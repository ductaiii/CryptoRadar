<x-app-layout>
    <!-- <x-slot name="header">

    </x-slot> -->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Section Top 10 --}}
                    <div id="coin-section">
                        <div class="flex items-center justify-between mb-6">
                            <!-- <h2 class="text-2xl font-extrabold text-blue-700">Top 10 Coin Vốn Hóa Lớn</h2> -->
                            <h2 class="text-3xl font-extrabold mb-8 text-center text-blue-700 drop-shadow">Top 10 Coin Vốn Hóa Lớn</h2>
                            <button onclick="showWatchlist()"
                                class="bg-gradient-to-r from-blue-500 to-purple-500 text-white px-4 py-2 rounded-lg font-semibold shadow hover:scale-105 transition">
                                Xem Watchlist
                            </button>

                        </div>
                        <div id="coin-list" class="flex flex-col gap-4"></div>
                    </div>

                    {{-- Modal Xem Watchlist --}}
                    <div id="watchlist-modal"
                        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
                        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-md p-6 relative">
                            <button onclick="closeWatchlist()"
                                class="absolute top-3 right-3 text-gray-400 hover:text-red-500 text-2xl font-bold">&times;</button>
                            <h3 class="text-xl font-bold mb-4 text-center text-blue-700">Watchlist của bạn</h3>
                            <div id="watchlist-content" class="flex flex-col gap-3"></div>
                        </div>
                    </div>

                    {{-- Modal Chart xem giá trong 7 ngày --}}
                    <div id="chart-modal"
                        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
                        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-2xl p-6 relative">
                            <button onclick="closeChartModal()"
                                class="absolute top-3 right-3 text-gray-400 hover:text-red-500 text-2xl font-bold">&times;</button>
                            <h3 id="chart-title" class="text-xl font-bold mb-4 text-center text-blue-700"></h3>
                            <canvas id="price-chart" height="120"></canvas>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // --- Helpers ---
        const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // --- State ---
        let COINS = [];       // lưu danh sách Top 10 từ CoinGecko
        let WATCHLIST = [];   // lưu danh sách coin_id trong watchlist của user

        // --- Fetch Data ---
        async function fetchCoins() {
            const url = 'https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&order=market_cap_desc&per_page=10&page=1';
            const res = await fetch(url);
            COINS = await res.json();
            await fetchWatchlist();
            renderCoins();
        }

        async function fetchWatchlist() {
            const res = await fetch('/watchlist/json', { credentials: 'same-origin' });
            let data = await res.json();
            if (!Array.isArray(data)) data = [];
            WATCHLIST = data;
        }


        // --- Watchlist actions ---
        function isInWatchlist(id) { return WATCHLIST.includes(id); }
        // hàm thêm coin vào watchlist
        async function addToWatchlist(id) {
            const coin = COINS.find(c => c.id === id);
            if (!coin || WATCHLIST.includes(id)) return;

            await fetch('/watchlist/add', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                credentials: 'same-origin',
                body: JSON.stringify({
                    coin_id: coin.id,
                    coin_symbol: coin.symbol,
                    coin_name: coin.name,
                    coin_image: coin.image
                })
            });
            WATCHLIST.push(id);
            renderCoins(); renderWatchlist();
        }

        async function removeFromWatchlist(id) {
            await fetch(`/watchlist/by-coin/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': CSRF },
                credentials: 'same-origin'
            });
            WATCHLIST = WATCHLIST.filter(c => c !== id);
            renderCoins(); renderWatchlist();
        }

        // --- Render list ---
        function renderCoins() {
            const container = document.getElementById('coin-list');
            container.innerHTML = '';
            if (!COINS.length) {
                container.innerHTML = '<div class="text-center text-gray-500">Đang tải dữ liệu...</div>';
                return;
            }

            COINS.forEach(coin => {
                const inWatch = !!isInWatchlist(coin.id); // always boolean
                const div = document.createElement('div');
                div.className = 'flex items-center justify-between bg-white dark:bg-gray-900 rounded-xl shadow p-4 hover:bg-blue-50 dark:hover:bg-gray-800 transition';

                // fallback text for button
                let btnText = inWatch ? 'Bỏ Watchlist' : 'Thêm vào Watchlist';
                let btnClass = '';
                if (inWatch) {
                    btnClass = 'bg-red-500 hover:bg-red-600 text-white rounded-lg px-5 py-2 font-semibold shadow transition-transform duration-200 transform hover:scale-105';
                } else {
                    btnClass = 'bg-gradient-to-r from-green-400 to-green-600 hover:from-green-500 hover:to-green-700 text-white rounded-lg px-5 py-2 font-semibold shadow transition-transform duration-200 transform hover:scale-105';
                }

                div.innerHTML = `
                    <div class="flex items-center gap-4 cursor-pointer" onclick="showChartModal('${coin.id}', '${coin.name}')">
                        <img src="${coin.image}" alt="${coin.symbol}" class="w-16 h-16 max-w-[64px] max-h-[64px] rounded-full border bg-white object-contain" style="background:#fff;" />
                        <div>
                            <div class="font-bold text-lg text-blue-700 dark:text-blue-300">${coin.name} <span class="uppercase text-gray-500">(${coin.symbol})</span></div>
                            <div class="text-gray-600 dark:text-gray-300 text-sm">Giá: <span class="font-semibold text-green-700 dark:text-green-400">$${coin.current_price.toLocaleString()}</span></div>
                            <div class="text-gray-600 dark:text-gray-300 text-sm">Vốn hóa: <span class="font-semibold">$${coin.market_cap.toLocaleString()}</span></div>
                            <div class="text-gray-600 dark:text-gray-300 text-sm">KL 24h: <span class="font-semibold">$${coin.total_volume.toLocaleString()}</span></div>
                            <div class="text-gray-600 dark:text-gray-300 text-sm">Thay đổi 24h: <span class="font-semibold ${coin.price_change_percentage_24h >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}">${coin.price_change_percentage_24h?.toFixed(2) ?? 0}%</span></div>
                        </div>
                    </div>
                    <button onclick="event.stopPropagation(); ${inWatch ? `removeFromWatchlist('${coin.id}')` : `addToWatchlist('${coin.id}')` }"
                        class="${btnClass}">
                        ${btnText}
                    </button>
                `;
                container.appendChild(div);
            });
        }

        // --- Watchlist modal ---
        function showWatchlist() {
            const modal = document.getElementById('watchlist-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            renderWatchlist();
        }
        function closeWatchlist() {
            const modal = document.getElementById('watchlist-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
        function renderWatchlist() {
            const content = document.getElementById('watchlist-content');
            content.innerHTML = '';
            if (!WATCHLIST.length) {
                content.innerHTML = '<div class="text-gray-500 text-center">Chưa có coin nào trong watchlist.</div>';
                return;
            }
            WATCHLIST.forEach(id => {
                const coin = COINS.find(c => c.id === id);
                if (!coin) return;
                const div = document.createElement('div');
                div.className = 'flex items-center justify-between bg-gray-100 dark:bg-gray-800 rounded-xl p-3';
                div.innerHTML = `
                    <div class="flex items-center gap-3">
                        <img src="${coin.image}" alt="${coin.symbol}" class="w-8 h-8 rounded-full border bg-white" />
                        <span class="font-bold text-blue-700">${coin.symbol.toUpperCase()}</span>
                        <span class="text-gray-600 text-sm">${coin.name}</span>
                    </div>
                    <button onclick="removeFromWatchlist('${coin.id}')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded font-semibold">Bỏ</button>
                `;
                content.appendChild(div);
            });
        }

        // --- Chart modal ---
        let chartInstance = null;
        async function showChartModal(coinId, coinName) {
            const modal = document.getElementById('chart-modal');
            modal.classList.remove('hidden'); modal.classList.add('flex');
            document.getElementById('chart-title').innerText = `Biểu đồ giá 7 ngày: ${coinName}`;

            const url = `https://api.coingecko.com/api/v3/coins/${coinId}/market_chart?vs_currency=usd&days=7`;
            const res = await fetch(url);
            const data = await res.json();
            const prices = data?.prices ?? [];

            const labels = prices.map(p => {
                const d = new Date(p[0]);
                return `${d.getDate()}/${d.getMonth()+1}`;
            });
            const values = prices.map(p => p[1]);

            const ctx = document.getElementById('price-chart').getContext('2d');
            if (chartInstance) chartInstance.destroy();
            chartInstance = new Chart(ctx, {
                type: 'line',
                data: { labels, datasets: [{ label: 'Giá USD', data: values, borderColor: '#3b82f6', backgroundColor: 'rgba(59,130,246,0.1)', fill: true, tension: 0.3 }] },
                options: { responsive: true, plugins: { legend: { display: false } } }
            });
        }
        function closeChartModal() {
            const modal = document.getElementById('chart-modal');
            modal.classList.add('hidden'); modal.classList.remove('flex');
        }

        // --- Boot ---
        window.onload = fetchCoins;
    </script>
</x-app-layout>
