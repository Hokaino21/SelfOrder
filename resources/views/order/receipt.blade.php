<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pesanan - Restoran</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            max-width: 600px;
            width: 100%;
        }

        .receipt {
            background: white;
            border-radius: 15px;
            padding: 40px 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .success-icon {
            font-size: 3em;
            margin-bottom: 15px;
            animation: pulse 0.6s ease-out;
        }

        @keyframes pulse {
            0% { transform: scale(0.8); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        .receipt-title {
            font-size: 1.8em;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .receipt-subtitle {
            color: #666;
            font-size: 0.95em;
            margin-bottom: 20px;
        }

        .status-badge {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 0.85em;
            font-weight: 700;
            margin: 10px 5px;
        }

        .status-pending { background: #fff3cd; color: #856404; }
        .status-preparing { background: #d1ecf1; color: #0c5460; }
        .status-ready { background: #d4edda; color: #155724; }
        .status-completed { background: #28a745; color: white; }

        .order-number-box {
            background: linear-gradient(135deg, var(--theme-start) 0%, var(--theme-end) 100%);
            color: white;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 30px;
        }

        .order-number-label {
            font-size: 0.85em;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .order-number-value {
            font-size: 2.2em;
            font-weight: 700;
            letter-spacing: 2px;
            font-family: 'Courier New', monospace;
        }

        .divider {
            border-top: 2px dashed #ddd;
            margin: 25px 0;
        }

        .receipt-section {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 0.85em;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--theme-main);
            letter-spacing: 1.5px;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #f0f0f0;
        }

        .receipt-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 0.95em;
            color: #333;
        }

        .receipt-label { color: #666; }
        .receipt-value { font-weight: 600; }

        .items-list {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px dotted #e0e0e0;
            font-size: 0.95em;
        }

        .item-row:last-child {
            border-bottom: none;
        }

        .item-name {
            font-weight: 600;
            color: #333;
            flex: 1;
        }

        .item-qty {
            color: #999;
            margin: 0 15px;
            min-width: 40px;
            text-align: center;
        }

        .item-price {
            font-weight: 700;
            color: var(--theme-main);
            min-width: 100px;
            text-align: right;
        }

        .summary-section {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 0.95em;
        }

        .summary-row.total {
            font-size: 1.3em;
            font-weight: 700;
            color: var(--theme-main);
            border-top: 2px solid #ddd;
            padding-top: 12px;
            margin-top: 12px;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            margin-top: 25px;
        }

        .btn {
            flex: 1;
            padding: 13px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            font-size: 0.95em;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--theme-start) 0%, var(--theme-end) 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #e0e0e0;
            color: #333;
        }

        .btn-secondary:hover {
            background: #d0d0d0;
        }

        .footer-text {
            text-align: center;
            color: #666;
            font-size: 0.85em;
            line-height: 1.6;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #f0f0f0;
        }

        @media print {
            body { background: white; padding: 0; }
            .action-buttons { display: none; }
            .receipt { box-shadow: none; border-radius: 0; }
        }

        @media (max-width: 600px) {
            .receipt { padding: 25px 20px; }
            .receipt-title { font-size: 1.4em; }
            .order-number-value { font-size: 1.6em; }
            .action-buttons { flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="receipt">
            <!-- Success Message -->
            @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: 600;">
                ✅ {{ session('success') }}
            </div>
            @endif

            <!-- Header -->
            <div class="receipt-header">
                <div class="success-icon">✅</div>
                <div class="receipt-title">{{ $order->status === 'ready' ? 'Pembayaran Berhasil' : 'Pesanan Berhasil Dibuat' }}</div>
                <div class="receipt-subtitle">{{ $order->status === 'ready' ? 'Pembayaran Anda telah diverifikasi' : 'Pesanan Anda telah diterima' }}</div>
                <div>
                    <span class="status-badge status-{{ $order->status }}">
                        @if($order->status == 'pending') ⏳ Menunggu Pembayaran
                        @elseif($order->status == 'preparing') 👨‍🍳 Sedang Diproses
                        @elseif($order->status == 'ready') ✓ Pembayaran Diterima
                        @elseif($order->status == 'completed') ✓ Selesai
                        @else Dibatalkan @endif
                    </span>
                </div>
            </div>

            <!-- Order Number -->
            <div class="order-number-box">
                <div class="order-number-label">Nomor Pesanan</div>
                <div class="order-number-value">{{ $order->order_number }}</div>
            </div>

            <div class="divider"></div>

            <!-- Customer Info -->
            <div class="receipt-section">
                <div class="section-title">👤 Informasi Pemesan</div>
                <div class="receipt-row">
                    <span class="receipt-label">Nama</span>
                    <span class="receipt-value">{{ $order->customer_name }}</span>
                </div>
                @if($order->customer_phone)
                <div class="receipt-row">
                    <span class="receipt-label">Telepon</span>
                    <span class="receipt-value">{{ $order->customer_phone }}</span>
                </div>
                @endif
                <div class="receipt-row">
                    <span class="receipt-label">Waktu Pesan</span>
                    <span class="receipt-value">{{ $order->ordered_at ? $order->ordered_at->format('d/m/Y H:i') : $order->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>

            <div class="divider"></div>

            <!-- Items List -->
            <div class="receipt-section">
                <div class="section-title">📋 Detail Pesanan</div>
                <div class="items-list">
                    @forelse($order->items as $item)
                    <div class="item-row">
                        <span class="item-name">{{ $item->menuItem->name ?? 'Menu Tidak Ditemukan' }}</span>
                        <span class="item-qty">{{ $item->quantity }}x</span>
                        <span class="item-price">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                    </div>
                    @empty
                    <div style="text-align: center; color: #999; padding: 20px;">Tidak ada item</div>
                    @endforelse
                </div>
            </div>

            @if($order->notes)
            <div class="receipt-section">
                <div class="section-title">📝 Catatan Khusus</div>
                <div style="color: #666; line-height: 1.5;">{{ $order->notes }}</div>
            </div>
            @endif

            @if($order->payment_method)
            <div class="receipt-section">
                <div class="section-title">💳 Metode Pembayaran</div>
                <div class="receipt-row">
                    <span class="receipt-label">Metode</span>
                    <span class="receipt-value">
                        @if($order->payment_method == 'cash') Tunai
                        @elseif($order->payment_method == 'bank_transfer') Transfer Bank
                        @elseif($order->payment_method == 'ewallet') Dompet Digital
                        @endif
                    </span>
                </div>
                <div class="receipt-row">
                    <span class="receipt-label">Status</span>
                    <span class="receipt-value" style="color: #28a745; font-weight: 700;">✓ Berhasil Diverifikasi</span>
                </div>
            </div>
            @endif

            <!-- Summary -->
            <div class="summary-section">
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($order->total_price * 0.9, 0, ',', '.') }}</span>
                </div>
                <div class="summary-row">
                    <span>Pajak (10%)</span>
                    <span>Rp {{ number_format($order->total_price * 0.1, 0, ',', '.') }}</span>
                </div>
                <div class="summary-row total">
                    <span>Total Bayar</span>
                    <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Action Buttons -->
            @if($order->status === 'pending')
            <div class="action-buttons">
                <a href="{{ route('order.payment', $order->id) }}" class="btn btn-primary">💳 Lanjut Pembayaran</a>
                <a href="{{ route('order.track', $order->order_number) }}" class="btn btn-primary">📍 Tracking Pesanan</a>
            </div>
            @else
            <div class="action-buttons">
                <a href="{{ route('order.history') }}" class="btn btn-primary">📜 Riwayat Transaksi</a>
                <a href="{{ route('order.track', $order->order_number) }}" class="btn btn-primary">📍 Tracking Pesanan</a>
            </div>
            @endif

            <div class="action-buttons">
                <button onclick="window.print()" class="btn btn-secondary">🖨️ Cetak Struk</button>
                <a href="{{ route('menu.index') }}" class="btn btn-secondary">← Kembali Menu</a>
            </div>

            <!-- Footer -->
            <div class="footer-text">
                ✓ Simpan nomor pesanan untuk tracking<br>
                Estimasi waktu: 15-30 menit<br>
                Terima kasih telah memesan! 🙏
            </div>
        </div>
    </div>

    <!-- SweetAlert2 for customer notifications -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
        // Clear cart after successful order
        localStorage.removeItem('cart');

        // if we were redirected here with a flash success message (e.g. after a
        // card transaction or manual confirmation), show a modal as well
        @if(session('success'))
            Swal.fire({
                title: '✅ {{ addslashes(session('success')) }}',
                icon: 'success',
                confirmButtonColor: '#00BFFF',
                timer: 4000,
                timerProgressBar: true
            });
        @endif
    </script>
</body>
</html>
