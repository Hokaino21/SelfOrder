<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Pesanan - Restoran</title>
    <style>
        :root {
            --theme-start: #87CEEB;
            --theme-end: #00BFFF;
            --theme-main: #00BFFF;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--theme-start) 0%, var(--theme-end) 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        header {
            text-align: center;
            color: white;
            margin-bottom: 40px;
            position: relative;
        }

        h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .subtitle {
            font-size: 1.1em;
            opacity: 0.9;
        }

        .admin-btn {
            position: absolute;
            top: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            font-size: 0.95em;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .admin-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }

        .controls-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .search-box {
            margin-bottom: 20px;
        }

        .search-input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--theme-main);
            box-shadow: 0 0 0 3px rgba(0, 191, 255, 0.1);
        }

        .search-icon {
            position: relative;
            top: -35px;
            right: 15px;
            color: #999;
            pointer-events: none;
            float: right;
        }

        .filter-section {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-label {
            font-weight: 600;
            color: #333;
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 10px 20px;
            border: 2px solid var(--theme-main);
            background: white;
            color: var(--theme-main);
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .filter-btn:hover {
            background: var(--theme-main);
            color: white;
        }

        .filter-btn.active {
            background: var(--theme-main);
            color: white;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .menu-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .menu-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, var(--theme-start) 0%, var(--theme-end) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3em;
            overflow: hidden;
        }

        .menu-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .menu-content {
            padding: 20px;
        }

        .menu-name {
            font-size: 1.3em;
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
        }

        .menu-description {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 12px;
            line-height: 1.4;
        }

        .menu-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .menu-price {
            font-size: 1.5em;
            font-weight: 700;
            color: var(--theme-main);
        }

        .add-btn {
            padding: 10px 20px;
            background: linear-gradient(135deg, var(--theme-start) 0%, var(--theme-end) 100%);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .add-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 191, 255, 0.4);
        }

        /* Floating Cart Button */
        .cart-fab {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--theme-start) 0%, var(--theme-end) 100%);
            border: none;
            border-radius: 50%;
            color: white;
            font-size: 1.8em;
            cursor: pointer;
            box-shadow: 0 10px 30px rgba(0, 191, 255, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            z-index: 100;
        }

        .cart-fab:hover {
            transform: scale(1.1);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.5);
        }

        .cart-fab-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ff6b6b;
            color: white;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.8em;
            border: 2px solid white;
        }

        /* Modal Cart */
        .cart-modal {
            position: fixed;
            right: 0;
            top: 0;
            width: 400px;
            height: 100vh;
            background: white;
            box-shadow: -5px 0 20px rgba(0, 0, 0, 0.2);
            z-index: 200;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .cart-modal.active {
            transform: translateX(0);
        }

        .cart-modal-header {
            background: linear-gradient(135deg, var(--theme-start) 0%, var(--theme-end) 100%);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }

        .cart-modal-header h2 {
            font-size: 1.5em;
            margin: 0;
        }

        .cart-close-btn {
            background: none;
            border: none;
            color: white;
            font-size: 1.5em;
            cursor: pointer;
            padding: 0;
        }

        .cart-modal-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }

        .cart-empty {
            text-align: center;
            padding: 40px 20px;
            color: #999;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            background: #f5f5f5;
            border-radius: 8px;
            margin-bottom: 10px;
            font-size: 0.9em;
        }

        .cart-item-name {
            font-weight: 600;
            color: #333;
            flex: 1;
        }

        .cart-item-qty {
            display: flex;
            gap: 5px;
            align-items: center;
            margin: 0 10px;
        }

        .qty-btn {
            width: 24px;
            height: 24px;
            border: 1px solid var(--theme-main);
            background: white;
            color: var(--theme-main);
            cursor: pointer;
            border-radius: 4px;
            font-weight: 600;
            padding: 0;
            transition: all 0.2s ease;
        }

        .qty-btn:hover {
            background: var(--theme-main);
            color: white;
        }

        .qty-input {
            width: 35px;
            text-align: center;
            border: 1px solid #ddd;
            padding: 4px;
            border-radius: 4px;
            font-size: 0.9em;
        }

        .cart-item-price {
            font-weight: 700;
            color: var(--theme-main);
            margin-right: 8px;
            min-width: 80px;
            text-align: right;
        }

        .delete-btn {
            background: #ff6b6b;
            color: white;
            border: none;
            width: 24px;
            height: 24px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            padding: 0;
            transition: all 0.2s ease;
        }

        .delete-btn:hover {
            background: #ff5252;
        }

        .cart-modal-footer {
            background: #f9f9f9;
            padding: 20px;
            border-top: 1px solid #eee;
            flex-shrink: 0;
        }

        .cart-total {
            display: flex;
            justify-content: space-between;
            font-size: 1.3em;
            font-weight: 700;
            color: #333;
            margin-bottom: 15px;
        }

        .checkout-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, var(--theme-start) 0%, var(--theme-end) 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1.1em;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .checkout-btn:hover:not(:disabled) {
            transform: scale(1.02);
            box-shadow: 0 5px 20px rgba(0, 191, 255, 0.4);
        }

        .checkout-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Modal Backdrop */
        .cart-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 150;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .cart-backdrop.active {
            opacity: 1;
            pointer-events: auto;
        }

        .no-results {
            grid-column: 1/-1;
            text-align: center;
            color: white;
            padding: 60px 20px;
            font-size: 1.2em;
        }

        @media (max-width: 768px) {
            .menu-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }

            h1 {
                font-size: 1.8em;
            }

            .admin-btn {
                position: static;
                display: block;
                margin-bottom: 15px;
                justify-content: center;
            }

            .controls-section {
                padding: 15px;
            }

            .filter-section {
                flex-direction: column;
                align-items: flex-start;
            }

            .cart-modal {
                width: calc(100% - 40px);
                max-width: 100%;
                bottom: 0;
                height: auto;
                max-height: 90vh;
                border-radius: 15px 15px 0 0;
                transform: translateY(100%);
            }

            .cart-modal.active {
                transform: translateY(0);
            }

            .cart-fab {
                bottom: 20px;
                right: 20px;
                width: 60px;
                height: 60px;
                font-size: 1.5em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <a href="{{ route('admin.login') }}" class="admin-btn">🔐 Admin</a>
            <h1>🍽️ Menu Restoran</h1>
            <p class="subtitle">Pilih hidangan favorit Anda</p>
        </header>

        <div class="controls-section">
            <div class="search-box">
                <input 
                    type="text" 
                    class="search-input" 
                    id="searchInput" 
                    placeholder="🔍 Cari menu..."
                    onkeyup="searchMenu()"
                >
            </div>

            <div class="filter-section">
                <span class="filter-label">Kategori:</span>
                <div class="filter-buttons">
                    <button class="filter-btn {{ $category === 'all' ? 'active' : '' }}" onclick="filterMenu('all')">
                        Semua
                    </button>
                    @foreach ($categories as $cat)
                        <button class="filter-btn {{ $category === $cat ? 'active' : '' }}" onclick="filterMenu('{{ $cat }}')">
                            {{ $cat }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="menu-grid" id="menuGrid">
            @forelse ($menuItems as $item)
                <div class="menu-card" data-name="{{ strtolower($item->name) }}" data-category="{{ $item->category }}">
                    <div class="menu-image">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                        @else
                            @php
                                $icons = ['Makanan Berat' => '🍚', 'Makanan Ringan' => '🥡', 'Minuman' => '🥤', 'Dessert' => '🍰'];
                                $icon = $icons[$item->category] ?? '🍽️';
                            @endphp
                            {{ $icon }}
                        @endif
                    </div>
                    <div class="menu-content">
                        <div class="menu-name">{{ $item->name }}</div>
                        <div class="menu-description">{{ $item->description }}</div>
                        <div class="menu-footer">
                            <span class="menu-price">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                            <button class="add-btn" onclick="addToCart({{ $item->id }}, '{{ $item->name }}', {{ $item->price }}, event)">
                                + Tambah
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="no-results">Tidak ada menu tersedia</div>
            @endforelse
        </div>
    </div>

    <!-- Cart Modal -->
    <div class="cart-backdrop" id="cartBackdrop" onclick="toggleCart()"></div>
    <div class="cart-modal" id="cartModal">
        <div class="cart-modal-header">
            <h2>🛒 Keranjang Pesanan</h2>
            <button class="cart-close-btn" onclick="toggleCart()">✕</button>
        </div>
        <div class="cart-modal-body">
            <div class="cart-items" id="cartItems">
                <div class="cart-empty">Keranjang kosong</div>
            </div>
        </div>
        <div class="cart-modal-footer">
            <div class="cart-total">
                <span>Total:</span>
                <span id="cartTotal">Rp 0</span>
            </div>
            <button class="checkout-btn" id="checkoutBtn" onclick="checkout()" disabled>Lanjut ke Pembayaran ✓</button>
        </div>
    </div>

    <!-- Floating Cart Button -->
    <button class="cart-fab" onclick="toggleCart()">
        🛒
        <span class="cart-fab-badge" id="cartBadge" style="display: none;">0</span>
    </button>

    <script>
        let cart = JSON.parse(localStorage.getItem('cart')) || {};
        let allMenuItems = [
            @foreach ($menuItems as $item)
                { id: {{ $item->id }}, name: '{{ $item->name }}', category: '{{ $item->category }}' },
            @endforeach
        ];

        function toggleCart() {
            const modal = document.getElementById('cartModal');
            const backdrop = document.getElementById('cartBackdrop');
            modal.classList.toggle('active');
            backdrop.classList.toggle('active');
        }

        function addToCart(id, name, price, event) {
            if (!cart[id]) {
                cart[id] = { name, price, quantity: 0 };
            }
            cart[id].quantity++;
            saveCart();
            renderCart();
            
            // Show modal when adding item
            if (!document.getElementById('cartModal').classList.contains('active')) {
                toggleCart();
            }
        }

        // play a short click/beep using Web Audio API
        function playClickSound() {
            try {
                const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                const osc = audioContext.createOscillator();
                const gain = audioContext.createGain();
                osc.connect(gain);
                gain.connect(audioContext.destination);
                osc.frequency.value = 1200;
                osc.type = 'square';
                gain.gain.setValueAtTime(0.2, audioContext.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.1);
                osc.start(audioContext.currentTime);
                osc.stop(audioContext.currentTime + 0.1);
            } catch (e) {
                console.log('Audio playback failed:', e);
            }
        }

        function removeFromCart(id) {
            delete cart[id];
            saveCart();
            renderCart();
        }

        function updateQuantity(id, quantity) {
            if (quantity <= 0) {
                removeFromCart(id);
            } else {
                cart[id].quantity = parseInt(quantity);
                saveCart();
                renderCart();
            }
        }

        function saveCart() {
            localStorage.setItem('cart', JSON.stringify(cart));
        }

        function renderCart() {
            const cartItemsDiv = document.getElementById('cartItems');
            const cartTotalDiv = document.getElementById('cartTotal');
            const checkoutBtn = document.getElementById('checkoutBtn');
            const badge = document.getElementById('cartBadge');

            // Update badge
            const totalItems = Object.values(cart).reduce((sum, item) => sum + item.quantity, 0);
            if (totalItems === 0) {
                badge.style.display = 'none';
            } else {
                badge.textContent = totalItems;
                badge.style.display = 'flex';
            }

            if (Object.keys(cart).length === 0) {
                cartItemsDiv.innerHTML = '<div class="cart-empty">Keranjang kosong</div>';
                cartTotalDiv.textContent = 'Rp 0';
                checkoutBtn.disabled = true;
                return;
            }

            let total = 0;
            let html = '';

            for (const id in cart) {
                const item = cart[id];
                const itemTotal = item.price * item.quantity;
                total += itemTotal;

                html += `
                    <div class="cart-item">
                        <span class="cart-item-name">${item.name}</span>
                        <div class="cart-item-qty">
                            <button class="qty-btn" onclick="updateQuantity(${id}, ${item.quantity - 1})">−</button>
                            <input type="number" class="qty-input" value="${item.quantity}" onchange="updateQuantity(${id}, this.value)">
                            <button class="qty-btn" onclick="updateQuantity(${id}, ${item.quantity + 1})">+</button>
                        </div>
                        <span class="cart-item-price">Rp ${(itemTotal).toLocaleString('id-ID')}</span>
                        <button class="delete-btn" onclick="removeFromCart(${id})">×</button>
                    </div>
                `;
            }

            cartItemsDiv.innerHTML = html;
            cartTotalDiv.textContent = `Rp ${total.toLocaleString('id-ID')}`;
            checkoutBtn.disabled = false;
        }

        function checkout() {
            playClickSound();
            if (Object.keys(cart).length === 0) {
                alert('Keranjang kosong!');
                return;
            }
            window.location.href = '{{ route('order.create') }}';
        }

        function filterMenu(category) {
            const url = new URL(window.location);
            url.searchParams.set('category', category);
            window.location = url.toString();
        }

        function searchMenu() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const menuCards = document.querySelectorAll('.menu-card');
            let visibleCount = 0;

            menuCards.forEach(card => {
                const name = card.getAttribute('data-name');
                if (name.includes(searchInput)) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Show no results message
            const grid = document.getElementById('menuGrid');
            let noResults = grid.querySelector('.no-results-search');
            
            if (visibleCount === 0 && searchInput !== '') {
                if (!noResults) {
                    noResults = document.createElement('div');
                    noResults.className = 'no-results no-results-search';
                    noResults.textContent = '❌ Menu tidak ditemukan';
                    grid.appendChild(noResults);
                }
                noResults.style.display = '';
            } else if (noResults) {
                noResults.style.display = 'none';
            }
        }

        // Close cart modal when clicking outside (on backdrop)
        document.getElementById('cartBackdrop').addEventListener('click', function(e) {
            if (e.target === this) {
                toggleCart();
            }
        });

        // Load cart on page load
        renderCart();
    </script>
</body>
</html>
