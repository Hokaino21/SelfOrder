<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Self Order - Daftar Produk</title>
    <style>
        :root {
            --bg: #f4f7fb;
            --surface: #ffffff;
            --ink: #17202a;
            --muted: #657386;
            --line: #dbe3ee;
            --primary: #0f766e;
            --primary-dark: #115e59;
            --accent: #f97316;
            --accent-dark: #c2410c;
            --danger: #dc2626;
            --shadow: 0 18px 45px rgba(15, 23, 42, 0.12);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            background:
                linear-gradient(135deg, rgba(15, 118, 110, 0.94), rgba(17, 94, 89, 0.88)),
                url("https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=1800&q=80") center/cover fixed;
            color: var(--ink);
            padding: 24px;
        }

        .container { width: min(1240px, 100%); margin: 0 auto; }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 26px;
        }

        .brand { color: #ffffff; }

        .brand-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 12px;
            border: 1px solid rgba(255, 255, 255, 0.28);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.14);
            font-size: 0.85rem;
            font-weight: 700;
            margin-bottom: 12px;
        }

        h1 {
            font-size: clamp(2rem, 5vw, 4.2rem);
            line-height: 1;
            max-width: 760px;
            margin-bottom: 12px;
        }

        .subtitle {
            max-width: 620px;
            color: rgba(255, 255, 255, 0.86);
            font-size: 1.05rem;
            line-height: 1.6;
        }

        .admin-btn {
            flex: 0 0 auto;
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.4);
            background: rgba(255, 255, 255, 0.15);
            padding: 12px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.14);
            transition: transform 0.2s ease, background 0.2s ease;
        }

        .admin-btn:hover { transform: translateY(-2px); background: rgba(255, 255, 255, 0.24); }

        .ordering-shell {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 20px;
            align-items: start;
        }

        .menu-panel,
        .order-panel {
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid rgba(255, 255, 255, 0.7);
            border-radius: 8px;
            box-shadow: var(--shadow);
        }

        .controls-section {
            position: sticky;
            top: 0;
            z-index: 20;
            display: grid;
            gap: 16px;
            padding: 18px;
            border-bottom: 1px solid var(--line);
            background: rgba(255, 255, 255, 0.98);
            border-radius: 8px 8px 0 0;
        }

        .search-box { position: relative; }

        .search-input {
            width: 100%;
            min-height: 52px;
            padding: 0 16px 0 46px;
            border: 2px solid var(--line);
            border-radius: 8px;
            color: var(--ink);
            background: #f8fafc;
            font-size: 1rem;
            font-weight: 600;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.14);
        }

        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            pointer-events: none;
            font-weight: 900;
        }

        .filter-section { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
        .filter-label { color: var(--muted); font-size: 0.92rem; font-weight: 800; }
        .filter-buttons { display: flex; gap: 8px; flex-wrap: wrap; }

        .filter-btn {
            min-height: 40px;
            padding: 0 15px;
            border: 1px solid var(--line);
            background: #ffffff;
            color: var(--ink);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-weight: 800;
        }

        .filter-btn:hover,
        .filter-btn.active { border-color: var(--primary); background: var(--primary); color: #ffffff; }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 16px;
            padding: 18px;
        }

        .menu-card {
            min-height: 100%;
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--surface);
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .menu-card:hover {
            transform: translateY(-4px);
            border-color: rgba(15, 118, 110, 0.4);
            box-shadow: 0 16px 35px rgba(15, 23, 42, 0.14);
        }

        .menu-image {
            position: relative;
            width: 100%;
            aspect-ratio: 4 / 3;
            overflow: hidden;
            background: #e2e8f0;
        }

        .menu-image img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            transition: transform 0.25s ease;
        }

        .menu-card:hover .menu-image img { transform: scale(1.04); }

        .category-pill {
            position: absolute;
            left: 12px;
            top: 12px;
            max-width: calc(100% - 24px);
            padding: 6px 10px;
            border-radius: 999px;
            color: #ffffff;
            background: rgba(15, 23, 42, 0.72);
            backdrop-filter: blur(8px);
            font-size: 0.78rem;
            font-weight: 800;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .menu-content { display: grid; gap: 12px; padding: 16px; }
        .menu-name { min-height: 48px; color: var(--ink); font-size: 1.12rem; line-height: 1.28; font-weight: 850; }
        .menu-description { min-height: 42px; color: var(--muted); font-size: 0.92rem; line-height: 1.5; }

        .menu-footer {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 12px;
            align-items: center;
            padding-top: 2px;
        }

        .menu-price { color: var(--primary-dark); font-size: 1.18rem; font-weight: 900; }

        .add-btn {
            min-height: 42px;
            padding: 0 15px;
            background: var(--accent);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 900;
            transition: transform 0.2s ease, background 0.2s ease, box-shadow 0.2s ease;
        }

        .add-btn:hover { transform: translateY(-2px); background: var(--accent-dark); box-shadow: 0 12px 24px rgba(249, 115, 22, 0.3); }

        .order-panel { position: sticky; top: 24px; overflow: hidden; }
        .order-panel-header { padding: 18px; color: #ffffff; background: var(--ink); }
        .order-panel-header h2 { font-size: 1.2rem; margin-bottom: 6px; }
        .order-panel-header p { color: rgba(255, 255, 255, 0.72); font-size: 0.9rem; line-height: 1.45; }

        .cart-items { max-height: 420px; overflow-y: auto; padding: 14px; }

        .cart-empty {
            min-height: 180px;
            display: grid;
            place-items: center;
            text-align: center;
            color: var(--muted);
            background: #f8fafc;
            border: 1px dashed var(--line);
            border-radius: 8px;
            padding: 24px;
            font-weight: 700;
        }

        .cart-item {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 10px;
            padding: 12px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #ffffff;
            margin-bottom: 10px;
        }

        .cart-item-name { font-weight: 850; color: var(--ink); line-height: 1.35; }
        .cart-item-price { color: var(--primary-dark); font-weight: 900; white-space: nowrap; }

        .cart-item-actions {
            grid-column: 1 / -1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }

        .cart-item-qty {
            display: inline-flex;
            align-items: center;
            border: 1px solid var(--line);
            border-radius: 8px;
            overflow: hidden;
            background: #f8fafc;
        }

        .qty-btn {
            width: 34px;
            height: 34px;
            border: 0;
            background: transparent;
            color: var(--primary-dark);
            cursor: pointer;
            font-size: 1.05rem;
            font-weight: 900;
        }

        .qty-btn:hover { background: rgba(15, 118, 110, 0.1); }

        .qty-input {
            width: 42px;
            height: 34px;
            text-align: center;
            border: 0;
            border-left: 1px solid var(--line);
            border-right: 1px solid var(--line);
            background: #ffffff;
            color: var(--ink);
            font-weight: 800;
        }

        .delete-btn {
            min-height: 34px;
            padding: 0 11px;
            border: 1px solid rgba(220, 38, 38, 0.22);
            background: #fff1f2;
            color: var(--danger);
            border-radius: 8px;
            cursor: pointer;
            font-weight: 900;
        }

        .cart-modal-footer { padding: 16px; border-top: 1px solid var(--line); background: #f8fafc; }

        .cart-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            color: var(--ink);
            font-size: 1.15rem;
            font-weight: 900;
            margin-bottom: 14px;
        }

        .checkout-btn {
            width: 100%;
            min-height: 52px;
            padding: 0 18px;
            background: var(--primary);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-weight: 900;
            font-size: 1rem;
            cursor: pointer;
            transition: transform 0.2s ease, background 0.2s ease, box-shadow 0.2s ease;
        }

        .checkout-btn:hover:not(:disabled) { transform: translateY(-2px); background: var(--primary-dark); box-shadow: 0 12px 24px rgba(15, 118, 110, 0.28); }
        .checkout-btn:disabled { opacity: 0.45; cursor: not-allowed; }

        .cart-fab {
            position: fixed;
            right: 22px;
            bottom: 22px;
            z-index: 100;
            display: none;
            width: 64px;
            height: 64px;
            align-items: center;
            justify-content: center;
            border: none;
            border-radius: 999px;
            background: var(--accent);
            color: #ffffff;
            box-shadow: 0 16px 36px rgba(15, 23, 42, 0.25);
            cursor: pointer;
            font-size: 1.35rem;
            font-weight: 900;
        }

        .cart-fab-badge {
            position: absolute;
            top: -6px;
            right: -4px;
            min-width: 26px;
            height: 26px;
            padding: 0 7px;
            border: 2px solid #ffffff;
            border-radius: 999px;
            background: var(--danger);
            color: #ffffff;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 0.78rem;
        }

        .mobile-cart-sheet,
        .cart-backdrop { display: none; }

        .no-results {
            grid-column: 1 / -1;
            padding: 46px 18px;
            text-align: center;
            color: var(--muted);
            background: #f8fafc;
            border: 1px dashed var(--line);
            border-radius: 8px;
            font-weight: 800;
        }

        @media (max-width: 980px) {
            body { padding: 18px; }
            .topbar { align-items: flex-start; }
            .ordering-shell { grid-template-columns: 1fr; }
            .order-panel { display: none; }
            .cart-fab { display: flex; }

            .cart-backdrop {
                position: fixed;
                inset: 0;
                z-index: 150;
                background: rgba(15, 23, 42, 0.5);
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.2s ease;
            }

            .cart-backdrop.active { display: block; opacity: 1; pointer-events: auto; }

            .mobile-cart-sheet {
                position: fixed;
                left: 14px;
                right: 14px;
                bottom: 0;
                z-index: 200;
                display: flex;
                max-height: 86vh;
                flex-direction: column;
                overflow: hidden;
                background: #ffffff;
                border-radius: 8px 8px 0 0;
                box-shadow: 0 -20px 45px rgba(15, 23, 42, 0.24);
                transform: translateY(105%);
                transition: transform 0.25s ease;
            }

            .mobile-cart-sheet.active { transform: translateY(0); }
            .mobile-cart-sheet .cart-items { max-height: 48vh; }
        }

        @media (max-width: 680px) {
            body { padding: 14px; }
            .topbar { display: grid; }
            .admin-btn { justify-self: start; }
            .controls-section { position: static; }
            .filter-section { display: grid; }
            .menu-grid { grid-template-columns: 1fr; padding: 14px; }
            .menu-footer { grid-template-columns: 1fr; }
            .add-btn { width: 100%; }
        }
    </style>
</head>
<body>
    @php
        $fallbackImages = [
            'Nasi Goreng Spesial' => 'https://images.unsplash.com/photo-1512058564366-18510be2db19?auto=format&fit=crop&w=900&q=80',
            'Mie Goreng' => 'https://images.unsplash.com/photo-1585032226651-759b368d7246?auto=format&fit=crop&w=900&q=80',
            'Nasi Kuning' => 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?auto=format&fit=crop&w=900&q=80',
            'Ayam Bakar' => 'https://images.unsplash.com/photo-1532550907401-a500c9a57435?auto=format&fit=crop&w=900&q=80',
            'Ikan Goreng' => 'https://images.unsplash.com/photo-1580476262798-bddd9f4b7369?auto=format&fit=crop&w=900&q=80',
            'Lumpia' => 'https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?auto=format&fit=crop&w=900&q=80',
            'Perkedel' => 'https://images.unsplash.com/photo-1639024471283-03518883512d?auto=format&fit=crop&w=900&q=80',
            'Tahu Goreng' => 'https://images.unsplash.com/photo-1604909052743-94e838986d24?auto=format&fit=crop&w=900&q=80',
            'Bakso Goreng' => 'https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?auto=format&fit=crop&w=900&q=80',
            'Es Jeruk' => 'https://images.unsplash.com/photo-1621506289937-a8e4df240d0b?auto=format&fit=crop&w=900&q=80',
            'Es Teh Manis' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?auto=format&fit=crop&w=900&q=80',
            'Es Cendol' => 'https://images.unsplash.com/photo-1541658016709-82535e94bc69?auto=format&fit=crop&w=900&q=80',
            'Kopi Hitam' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?auto=format&fit=crop&w=900&q=80',
            'Susu Coklat' => 'https://images.unsplash.com/photo-1621506289937-a8e4df240d0b?auto=format&fit=crop&w=900&q=80',
            'Pisang Goreng' => 'https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?auto=format&fit=crop&w=900&q=80',
            'Es Krim' => 'https://images.unsplash.com/photo-1621506289937-a8e4df240d0b?auto=format&fit=crop&w=900&q=80',
            'Puding Coklat' => 'https://images.unsplash.com/photo-1512058564366-18510be2db19?auto=format&fit=crop&w=900&q=80',
        ];

        $categoryImages = [
            'Makanan Berat' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=900&q=80',
            'Makanan Ringan' => 'https://images.unsplash.com/photo-1541592106381-b31e9677c0e5?auto=format&fit=crop&w=900&q=80',
            'Minuman' => 'https://images.unsplash.com/photo-1544145945-f90425340c7e?auto=format&fit=crop&w=900&q=80',
            'Dessert' => 'https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?auto=format&fit=crop&w=900&q=80',
        ];
    @endphp

    <div class="container">
        <div class="topbar">
            <header class="brand">
                <div class="brand-kicker">Self Order System</div>
                <h1>Pilih menu, langsung masuk keranjang.</h1>
                <p class="subtitle">Tampilan produk dibuat lebih jelas untuk pemesanan mandiri: foto besar, harga kontras, dan tombol tambah yang mudah ditekan.</p>
            </header>

            <a href="{{ route('admin.login') }}" class="admin-btn">Admin</a>
        </div>

        <main class="ordering-shell">
            <section class="menu-panel">
                <div class="controls-section">
                    <div class="search-box">
                        <span class="search-icon">/</span>
                        <input type="text" class="search-input" id="searchInput" placeholder="Cari nama menu..." onkeyup="searchMenu()">
                    </div>

                    <div class="filter-section">
                        <span class="filter-label">Kategori</span>
                        <div class="filter-buttons">
                            <button class="filter-btn {{ $category === 'all' ? 'active' : '' }}" onclick="filterMenu('all')">Semua</button>
                            @foreach ($categories as $cat)
                                <button class="filter-btn {{ $category === $cat ? 'active' : '' }}" onclick="filterMenu(@js($cat))">{{ $cat }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="menu-grid" id="menuGrid">
                    @forelse ($menuItems as $item)
                        @php
                            $imageUrl = $item->image
                                ? asset('storage/' . $item->image)
                                : ($fallbackImages[$item->name] ?? ($categoryImages[$item->category] ?? 'https://images.unsplash.com/photo-1551218808-94e220e084d2?auto=format&fit=crop&w=900&q=80'));
                        @endphp
                        <article class="menu-card" data-name="{{ strtolower($item->name) }}" data-category="{{ $item->category }}">
                            <div class="menu-image">
                                <img src="{{ $imageUrl }}" alt="{{ $item->name }}" loading="lazy" data-fallback="{{ $categoryImages[$item->category] ?? $categoryImages['Makanan Berat'] }}" onerror="this.onerror=null; this.src=this.dataset.fallback;">
                                <span class="category-pill">{{ $item->category }}</span>
                            </div>
                            <div class="menu-content">
                                <div class="menu-name">{{ $item->name }}</div>
                                <div class="menu-description">{{ $item->description }}</div>
                                <div class="menu-footer">
                                    <span class="menu-price">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                    <button class="add-btn" onclick="addToCart({{ $item->id }}, @js($item->name), {{ $item->price }})">Tambah</button>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="no-results">Belum ada menu tersedia.</div>
                    @endforelse
                </div>
            </section>

            <aside class="order-panel" aria-label="Keranjang pesanan">
                <div class="order-panel-header">
                    <h2>Keranjang Pesanan</h2>
                    <p>Pesanan Anda akan muncul di sini sebelum lanjut ke pembayaran.</p>
                </div>
                <div class="cart-items" id="cartItems"><div class="cart-empty">Keranjang masih kosong.</div></div>
                <div class="cart-modal-footer">
                    <div class="cart-total"><span>Total</span><span id="cartTotal">Rp 0</span></div>
                    <button class="checkout-btn" id="checkoutBtn" onclick="checkout()" disabled>Lanjut ke Pembayaran</button>
                </div>
            </aside>
        </main>
    </div>

    <div class="cart-backdrop" id="cartBackdrop" onclick="toggleCart()"></div>
    <div class="mobile-cart-sheet" id="cartModal" aria-label="Keranjang pesanan mobile">
        <div class="order-panel-header">
            <h2>Keranjang Pesanan</h2>
            <p>Cek ulang item sebelum melanjutkan pembayaran.</p>
        </div>
        <div class="cart-items" id="cartItemsMobile"><div class="cart-empty">Keranjang masih kosong.</div></div>
        <div class="cart-modal-footer">
            <div class="cart-total"><span>Total</span><span id="cartTotalMobile">Rp 0</span></div>
            <button class="checkout-btn" id="checkoutBtnMobile" onclick="checkout()" disabled>Lanjut ke Pembayaran</button>
        </div>
    </div>

    <button class="cart-fab" onclick="toggleCart()" aria-label="Buka keranjang">
        <span>Cart</span>
        <span class="cart-fab-badge" id="cartBadge">0</span>
    </button>

    <script>
        let cart = JSON.parse(localStorage.getItem('cart')) || {};

        function toggleCart() {
            document.getElementById('cartModal').classList.toggle('active');
            document.getElementById('cartBackdrop').classList.toggle('active');
        }

        function addToCart(id, name, price) {
            if (!cart[id]) {
                cart[id] = { name, price, quantity: 0 };
            }

            cart[id].quantity++;
            saveCart();
            renderCart();
        }

        function playClickSound() {
            try {
                const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                const osc = audioContext.createOscillator();
                const gain = audioContext.createGain();
                osc.connect(gain);
                gain.connect(audioContext.destination);
                osc.frequency.value = 880;
                osc.type = 'sine';
                gain.gain.setValueAtTime(0.16, audioContext.currentTime);
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
            const parsedQuantity = parseInt(quantity, 10);

            if (!parsedQuantity || parsedQuantity <= 0) {
                removeFromCart(id);
                return;
            }

            cart[id].quantity = parsedQuantity;
            saveCart();
            renderCart();
        }

        function saveCart() {
            localStorage.setItem('cart', JSON.stringify(cart));
        }

        function cartMarkup() {
            if (Object.keys(cart).length === 0) {
                return '<div class="cart-empty">Keranjang masih kosong.</div>';
            }

            let html = '';

            for (const id in cart) {
                const item = cart[id];
                const itemTotal = item.price * item.quantity;

                html += `
                    <div class="cart-item">
                        <span class="cart-item-name">${item.name}</span>
                        <span class="cart-item-price">Rp ${itemTotal.toLocaleString('id-ID')}</span>
                        <div class="cart-item-actions">
                            <div class="cart-item-qty">
                                <button class="qty-btn" onclick="updateQuantity(${id}, ${item.quantity - 1})">-</button>
                                <input type="number" class="qty-input" value="${item.quantity}" min="1" onchange="updateQuantity(${id}, this.value)">
                                <button class="qty-btn" onclick="updateQuantity(${id}, ${item.quantity + 1})">+</button>
                            </div>
                            <button class="delete-btn" onclick="removeFromCart(${id})">Hapus</button>
                        </div>
                    </div>
                `;
            }

            return html;
        }

        function renderCart() {
            const totalItems = Object.values(cart).reduce((sum, item) => sum + item.quantity, 0);
            const total = Object.values(cart).reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const markup = cartMarkup();
            const formattedTotal = `Rp ${total.toLocaleString('id-ID')}`;
            const hasItems = totalItems > 0;

            document.getElementById('cartItems').innerHTML = markup;
            document.getElementById('cartItemsMobile').innerHTML = markup;
            document.getElementById('cartTotal').textContent = formattedTotal;
            document.getElementById('cartTotalMobile').textContent = formattedTotal;
            document.getElementById('checkoutBtn').disabled = !hasItems;
            document.getElementById('checkoutBtnMobile').disabled = !hasItems;

            const badge = document.getElementById('cartBadge');
            badge.textContent = totalItems;
            badge.style.display = hasItems ? 'flex' : 'none';
        }

        function checkout() {
            playClickSound();

            if (Object.keys(cart).length === 0) {
                alert('Keranjang masih kosong.');
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
                const isVisible = name.includes(searchInput);
                card.style.display = isVisible ? '' : 'none';
                visibleCount += isVisible ? 1 : 0;
            });

            const grid = document.getElementById('menuGrid');
            let noResults = grid.querySelector('.no-results-search');

            if (visibleCount === 0 && searchInput !== '') {
                if (!noResults) {
                    noResults = document.createElement('div');
                    noResults.className = 'no-results no-results-search';
                    noResults.textContent = 'Menu tidak ditemukan.';
                    grid.appendChild(noResults);
                }
                noResults.style.display = '';
            } else if (noResults) {
                noResults.style.display = 'none';
            }
        }

        renderCart();
    </script>
</body>
</html>
