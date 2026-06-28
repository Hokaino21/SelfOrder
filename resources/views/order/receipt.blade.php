<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pesanan</title>
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
            --success: #16a34a;
            --warning: #f97316;
            --danger: #dc2626;
            --shadow: 0 18px 45px rgba(15, 23, 42, 0.14);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { min-height: 100vh; padding: 24px; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; color: var(--ink); background: linear-gradient(135deg, rgba(23,32,42,.94), rgba(17,94,89,.9)); }
        .page { width: min(1000px, 100%); margin: 0 auto; }
        .hero { color: white; margin-bottom: 22px; display: flex; justify-content: space-between; gap: 18px; align-items: flex-end; }
        .eyebrow { display: inline-block; padding: 7px 12px; border: 1px solid rgba(255,255,255,.28); border-radius: 999px; background: rgba(255,255,255,.14); font-weight: 800; font-size: .84rem; margin-bottom: 12px; }
        h1 { font-size: clamp(2rem, 5vw, 3.7rem); line-height: 1; margin-bottom: 10px; }
        .hero p { color: rgba(255,255,255,.84); line-height: 1.6; max-width: 620px; }
        .status-pill { background: rgba(255,255,255,.16); border: 1px solid rgba(255,255,255,.32); border-radius: 8px; padding: 12px 14px; color: white; font-weight: 900; white-space: nowrap; }

        .invoice { background: rgba(255,255,255,.98); border-radius: 8px; box-shadow: var(--shadow); overflow: hidden; }
        .steps { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; padding: 16px; border-bottom: 1px solid var(--line); background: #f8fafc; }
        .step { min-height: 72px; padding: 10px; border: 1px solid var(--line); border-radius: 8px; background: white; }
        .step-number { width: 26px; height: 26px; display: grid; place-items: center; border-radius: 999px; background: #e2e8f0; color: var(--muted); font-weight: 900; font-size: .82rem; margin-bottom: 8px; }
        .step-title { font-weight: 900; font-size: .9rem; }
        .step-text { color: var(--muted); font-size: .78rem; margin-top: 3px; }
        .step.done .step-number, .step.active .step-number { background: var(--primary); color: white; }
        .step.active { border-color: rgba(249,115,22,.55); box-shadow: inset 0 0 0 2px rgba(249,115,22,.12); }
        .step.active .step-number { background: var(--accent); }

        .invoice-head { display: grid; grid-template-columns: 1fr auto; gap: 18px; padding: 24px; border-bottom: 1px solid var(--line); }
        .invoice-title { font-size: 1.45rem; font-weight: 950; margin-bottom: 6px; }
        .invoice-subtitle { color: var(--muted); line-height: 1.5; }
        .invoice-number { text-align: right; }
        .invoice-number span { display: block; color: var(--muted); font-size: .82rem; font-weight: 800; text-transform: uppercase; margin-bottom: 5px; }
        .invoice-number strong { font-family: "Courier New", monospace; font-size: 1.7rem; color: var(--primary-dark); }

        .content { display: grid; grid-template-columns: 1fr 320px; gap: 20px; padding: 24px; }
        .section { margin-bottom: 20px; }
        .section-title { color: var(--primary-dark); font-weight: 950; text-transform: uppercase; font-size: .84rem; margin-bottom: 10px; }
        .box { background: #f8fafc; border: 1px solid var(--line); border-radius: 8px; padding: 14px; }
        .row { display: flex; justify-content: space-between; gap: 12px; padding: 9px 0; border-bottom: 1px solid var(--line); color: var(--muted); }
        .row:last-child { border-bottom: 0; }
        .row strong { color: var(--ink); text-align: right; }
        .items .row { align-items: center; }
        .item-name { color: var(--ink); font-weight: 850; }
        .item-meta { color: var(--muted); font-size: .88rem; margin-top: 2px; }
        .item-price { color: var(--primary-dark); font-weight: 900; white-space: nowrap; }
        .total-card { background: linear-gradient(135deg, var(--primary-dark), var(--primary)); color: white; border-radius: 8px; padding: 18px; margin-bottom: 14px; }
        .total-card span { display: block; opacity: .82; font-weight: 800; font-size: .78rem; text-transform: uppercase; margin-bottom: 6px; }
        .total-card strong { display: block; font-family: "Courier New", monospace; font-size: 2rem; }
        .badge { display: inline-flex; padding: 8px 12px; border-radius: 999px; font-weight: 900; font-size: .84rem; }
        .status-pending { background: #ffedd5; color: #9a3412; }
        .status-preparing { background: #ccfbf1; color: #115e59; }
        .status-ready, .status-completed { background: #dcfce7; color: #166534; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }
        .actions { display: flex; gap: 10px; padding: 0 24px 24px; }
        .btn { flex: 1; min-height: 48px; display: inline-flex; align-items: center; justify-content: center; padding: 0 16px; border: 0; border-radius: 8px; text-decoration: none; cursor: pointer; font-weight: 900; color: var(--ink); background: #e2e8f0; }
        .btn-primary { background: var(--primary); color: white; }
        .footer-note { color: var(--muted); line-height: 1.55; font-size: .9rem; }
        .flash { margin: 24px 24px 0; background: #dcfce7; color: #166534; border-left: 4px solid var(--success); padding: 12px; border-radius: 8px; font-weight: 800; }

        @media print { body { background: white; padding: 0; } .hero, .steps, .actions { display: none; } .invoice { box-shadow: none; } }
        @media (max-width: 820px) { .hero, .invoice-head { display: block; } .invoice-number { text-align: left; margin-top: 16px; } .content { grid-template-columns: 1fr; } .steps { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 560px) { body { padding: 14px; } .actions { flex-direction: column; } .invoice-head, .content { padding: 18px; } }
    </style>
</head>
<body>
    <div class="page">
        <header class="hero">
            <div>
                <span class="eyebrow">Step {{ $order->status === 'pending' ? '1 dari 4' : '4 dari 4' }}</span>
                <h1>Invoice Pesanan</h1>
                <p>{{ $order->status === 'pending' ? 'Pesanan sudah dibuat. Lanjutkan pembayaran untuk membuka tracking penuh.' : 'Pembayaran tercatat. Simpan invoice ini untuk pengambilan dan arsip transaksi.' }}</p>
            </div>
            <div class="status-pill">#{{ $order->order_number }}</div>
        </header>

        <main class="invoice">
            <div class="steps">
                <div class="step {{ $order->status ? 'done' : 'active' }}"><div class="step-number">1</div><div class="step-title">Konfirmasi</div><div class="step-text">Data pesanan</div></div>
                <div class="step {{ $order->status === 'pending' ? 'active' : 'done' }}"><div class="step-number">2</div><div class="step-title">Pembayaran</div><div class="step-text">Verifikasi</div></div>
                <div class="step {{ $order->status === 'pending' ? '' : 'done' }}"><div class="step-number">3</div><div class="step-title">Tracking</div><div class="step-text">Status dapur</div></div>
                <div class="step {{ $order->status === 'pending' ? '' : 'active' }}"><div class="step-number">4</div><div class="step-title">Invoice</div><div class="step-text">Struk akhir</div></div>
            </div>

            @if(session('success'))
                <div class="flash">{{ session('success') }}</div>
            @endif

            <div class="invoice-head">
                <div>
                    <div class="invoice-title">{{ $order->status === 'pending' ? 'Pesanan Menunggu Pembayaran' : 'Invoice Pembayaran' }}</div>
                    <div class="invoice-subtitle">Dibuat pada {{ $order->ordered_at ? $order->ordered_at->format('d/m/Y H:i') : $order->created_at->format('d/m/Y H:i') }}</div>
                </div>
                <div class="invoice-number"><span>Nomor Pesanan</span><strong>{{ $order->order_number }}</strong></div>
            </div>

            <div class="content">
                <section>
                    <div class="section">
                        <div class="section-title">Informasi Pemesan</div>
                        <div class="box">
                            <div class="row"><span>Nama</span><strong>{{ $order->customer_name }}</strong></div>
                            @if($order->customer_phone)<div class="row"><span>Telepon</span><strong>{{ $order->customer_phone }}</strong></div>@endif
                            <div class="row"><span>Status</span><strong><span class="badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></strong></div>
                            @if($order->payment_method)
                                <div class="row"><span>Metode Pembayaran</span><strong>@if($order->payment_method == 'cash') Tunai @elseif($order->payment_method == 'bank_transfer') Transfer Bank @elseif($order->payment_method == 'ewallet') Dompet Digital @endif</strong></div>
                            @endif
                        </div>
                    </div>

                    <div class="section">
                        <div class="section-title">Detail Item</div>
                        <div class="box items">
                            @forelse($order->items as $item)
                                <div class="row">
                                    <div><div class="item-name">{{ $item->menuItem->name ?? 'Menu Tidak Ditemukan' }}</div><div class="item-meta">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</div></div>
                                    <div class="item-price">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
                                </div>
                            @empty
                                <div class="row"><span>Tidak ada item</span><strong>-</strong></div>
                            @endforelse
                        </div>
                    </div>

                    @if($order->notes)
                    <div class="section">
                        <div class="section-title">Catatan</div>
                        <div class="box footer-note">{{ $order->notes }}</div>
                    </div>
                    @endif
                </section>

                <aside>
                    <div class="total-card"><span>Total Bayar</span><strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong></div>
                    <div class="box">
                        <div class="row"><span>Subtotal</span><strong>Rp {{ number_format($order->total_price * 0.9, 0, ',', '.') }}</strong></div>
                        <div class="row"><span>Pajak 10%</span><strong>Rp {{ number_format($order->total_price * 0.1, 0, ',', '.') }}</strong></div>
                        <div class="row"><span>Total</span><strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong></div>
                    </div>
                    <p class="footer-note" style="margin-top:14px;">Simpan nomor pesanan untuk tracking dan tunjukkan invoice ini saat pengambilan.</p>
                </aside>
            </div>

            <div class="actions">
                @if($order->status === 'pending')
                    <a href="{{ route('order.payment', $order->id) }}" class="btn btn-primary">Lanjut Pembayaran</a>
                @else
                    <a href="{{ route('order.track', $order->order_number) }}" class="btn btn-primary">Tracking Pesanan</a>
                @endif
                <button onclick="window.print()" class="btn">Cetak Invoice</button>
                <a href="{{ route('menu.index') }}" class="btn">Kembali ke Menu</a>
            </div>
        </main>
    </div>

    <script>
        localStorage.removeItem('cart');
    </script>
</body>
</html>