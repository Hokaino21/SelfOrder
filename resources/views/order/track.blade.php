<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking Pesanan - Restoran</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

        .tracking-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 10px;
            font-size: 1.8em;
        }

        .tracking-subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
        }

        .order-info {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            color: #333;
        }

        .info-label {
            font-weight: 600;
            color: #666;
        }

        .info-value {
            font-weight: 700;
            color: #667eea;
        }

        .status-timeline {
            position: relative;
            padding: 20px 0;
        }

        .timeline-item {
            position: relative;
            padding-left: 50px;
            margin-bottom: 25px;
        }

        .timeline-dot {
            position: absolute;
            left: 0;
            top: 0;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: #ddd;
            border: 3px solid white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5em;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .timeline-item.active .timeline-dot {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.4);
        }

        .timeline-item.completed .timeline-dot {
            background: #4caf50;
        }

        .timeline-line {
            position: absolute;
            left: 17px;
            top: 35px;
            width: 2px;
            height: 25px;
            background: #ddd;
        }

        .timeline-item.active .timeline-line {
            background: linear-gradient(to bottom, #667eea, #764ba2);
        }

        .timeline-item.completed .timeline-line {
            background: #4caf50;
        }

        .timeline-item:last-child .timeline-line {
            display: none;
        }

        .timeline-content {
            background: #f9f9f9;
            padding: 12px;
            border-radius: 8px;
            border-left: 3px solid #ddd;
        }

        .timeline-item.active .timeline-content {
            background: #f0f4ff;
            border-left-color: #667eea;
        }

        .timeline-item.completed .timeline-content {
            background: #f1f8f4;
            border-left-color: #4caf50;
        }

        .timeline-title {
            font-weight: 700;
            color: #333;
            margin-bottom: 3px;
            text-transform: uppercase;
            font-size: 0.9em;
        }

        .timeline-description {
            color: #666;
            font-size: 0.9em;
        }

        .divider {
            border-top: 2px dashed #ddd;
            margin: 25px 0;
        }

        .order-items {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
        }

        .order-items-title {
            font-weight: 700;
            color: #333;
            margin-bottom: 12px;
            text-transform: uppercase;
            font-size: 0.9em;
            letter-spacing: 1px;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px dotted #ddd;
            font-size: 0.95em;
            color: #333;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .item-qty {
            color: #666;
            margin: 0 15px;
        }

        .item-price {
            font-weight: 600;
            color: #667eea;
        }

        .order-total {
            display: flex;
            justify-content: space-between;
            padding-top: 12px;
            border-top: 2px solid #ddd;
            font-weight: 700;
            color: #667eea;
            font-size: 1.1em;
            margin-top: 12px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        button {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .refresh-btn {
            background: #667eea;
            color: white;
        }

        .refresh-btn:hover {
            background: #5568d3;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .home-btn {
            background: #e0e0e0;
            color: #333;
        }

        .home-btn:hover {
            background: #d0d0d0;
        }

        .note {
            background: #fff3cd;
            padding: 12px;
            border-radius: 8px;
            margin-top: 15px;
            color: #856404;
            font-size: 0.9em;
            text-align: center;
        }

        @media (max-width: 600px) {
            .tracking-card {
                padding: 20px;
            }

            h1 {
                font-size: 1.4em;
            }

            .action-buttons {
                flex-direction: column;
            }

            .info-row {
                flex-direction: column;
                gap: 3px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="tracking-card">
            <h1>📍 Tracking Pesanan</h1>
            <p class="tracking-subtitle">Pantau status pesanan Anda secara real-time</p>

            <!-- Info Pesanan -->
            <div class="order-info">
                <div class="info-row">
                    <span class="info-label">Nomor Pesanan:</span>
                    <span class="info-value">{{ $order->order_number }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Nama Pemesan:</span>
                    <span class="info-value">{{ $order->customer_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value" style="text-transform: uppercase;">{{ $order->status }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Total:</span>
                    <span class="info-value">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Status Timeline -->
            <div class="status-timeline">
                <div class="timeline-item {{ in_array($order->status, ['pending', 'preparing', 'ready', 'completed']) ? 'completed' : '' }}">
                    <div class="timeline-dot">✓</div>
                    <div class="timeline-line"></div>
                    <div class="timeline-content">
                        <div class="timeline-title">Pesanan Diterima</div>
                        <div class="timeline-description">{{ $order->ordered_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>

                <div class="timeline-item {{ $order->status === 'pending' ? 'active' : ($order->status === 'preparing' || $order->status === 'ready' || $order->status === 'completed' ? 'completed' : '') }}">
                    <div class="timeline-dot">⚙️</div>
                    <div class="timeline-line"></div>
                    <div class="timeline-content">
                        <div class="timeline-title">Sedang Diproses</div>
                        <div class="timeline-description">Koki sedang menyiapkan pesanan Anda</div>
                    </div>
                </div>

                <div class="timeline-item {{ $order->status === 'preparing' ? 'active' : ($order->status === 'ready' || $order->status === 'completed' ? 'completed' : '') }}">
                    <div class="timeline-dot">🍽️</div>
                    <div class="timeline-line"></div>
                    <div class="timeline-content">
                        <div class="timeline-title">Sedang Disiapkan</div>
                        <div class="timeline-description">Makanan sedang dipersiapkan dengan sempurna</div>
                    </div>
                </div>

                <div class="timeline-item {{ $order->status === 'ready' ? 'active' : ($order->status === 'completed' ? 'completed' : '') }}">
                    <div class="timeline-dot">✨</div>
                    <div class="timeline-line"></div>
                    <div class="timeline-content">
                        <div class="timeline-title">Siap Diambil</div>
                        <div class="timeline-description">Pesanan Anda sudah siap!</div>
                    </div>
                </div>

                <div class="timeline-item {{ $order->status === 'completed' ? 'active' : '' }}">
                    <div class="timeline-dot">🎉</div>
                    <div class="timeline-content">
                        <div class="timeline-title">Selesai</div>
                        <div class="timeline-description">{{ $order->completed_at ? $order->completed_at->format('d/m/Y H:i') : 'Menunggu pengambilan' }}</div>
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <!-- Detail Pesanan -->
            <div class="order-items">
                <div class="order-items-title">📋 Detail Pesanan</div>
                @foreach ($order->items as $item)
                    <div class="order-item">
                        <div>{{ $item->menuItem->name }}</div>
                        <div class="item-qty">{{ $item->quantity }}x</div>
                        <div class="item-price">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
                    </div>
                @endforeach
                <div class="order-total">
                    <span>Total Pesanan:</span>
                    <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            @if ($order->status === 'pending' || $order->status === 'preparing')
                <div class="note">
                    ⏱️ Estimasi waktu tunggu: 15-30 menit tergantung antrian
                </div>
            @elseif ($order->status === 'ready')
                <div class="note" style="background: #d4edda; color: #155724;">
                    ✓ Pesanan Anda sudah siap! Silakan ambil di counter
                </div>
            @elseif ($order->status === 'completed')
                <div class="note" style="background: #d4edda; color: #155724;">
                    ✓ Terima kasih telah memesan! Kami tunggu kunjungan Anda lagi
                </div>
            @endif

            <div class="action-buttons">
                <button class="refresh-btn" onclick="location.reload()">🔄 Segarkan</button>
                <button class="home-btn" onclick="window.location.href='{{ route('menu.index') }}'">← Kembali</button>
            </div>
        </div>
    </div>

    <script>
        // Auto-refresh setiap 10 detik jika belum selesai
        @if (!in_array($order->status, ['completed', 'cancelled']))
            setInterval(function() {
                location.reload();
            }, 10000);
        @endif
    </script>
</body>
</html>
