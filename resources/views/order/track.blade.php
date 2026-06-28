<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking Pesanan</title>
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
            --danger: #dc2626;
            --shadow: 0 18px 45px rgba(15, 23, 42, 0.14);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { min-height: 100vh; padding: 24px; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; color: var(--ink); background: linear-gradient(135deg, rgba(23,32,42,.94), rgba(17,94,89,.9)); }
        .page { width: min(1120px, 100%); margin: 0 auto; }
        .hero { color: white; margin-bottom: 22px; display: flex; justify-content: space-between; gap: 18px; align-items: flex-end; }
        .eyebrow { display: inline-block; padding: 7px 12px; border: 1px solid rgba(255,255,255,.28); border-radius: 999px; background: rgba(255,255,255,.14); font-weight: 800; font-size: .84rem; margin-bottom: 12px; }
        h1 { font-size: clamp(2rem, 5vw, 3.8rem); line-height: 1; margin-bottom: 10px; }
        .hero p { color: rgba(255,255,255,.84); line-height: 1.6; max-width: 620px; }
        .order-chip { background: rgba(255,255,255,.16); border: 1px solid rgba(255,255,255,.32); border-radius: 8px; padding: 12px 14px; color: white; font-weight: 900; white-space: nowrap; }

        .shell { display: grid; grid-template-columns: minmax(0, 1fr) 340px; gap: 18px; align-items: start; }
        .panel { background: rgba(255,255,255,.98); border-radius: 8px; box-shadow: var(--shadow); overflow: hidden; }
        .panel-body { padding: 20px; }
        .steps { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; padding: 16px; border-bottom: 1px solid var(--line); background: #f8fafc; }
        .step { min-height: 72px; padding: 10px; border: 1px solid var(--line); border-radius: 8px; background: white; }
        .step-number { width: 26px; height: 26px; display: grid; place-items: center; border-radius: 999px; background: #e2e8f0; color: var(--muted); font-weight: 900; font-size: .82rem; margin-bottom: 8px; }
        .step-title { font-weight: 900; font-size: .9rem; }
        .step-text { color: var(--muted); font-size: .78rem; margin-top: 3px; }
        .step.done .step-number, .step.active .step-number { background: var(--primary); color: white; }
        .step.active { border-color: rgba(249,115,22,.55); box-shadow: inset 0 0 0 2px rgba(249,115,22,.12); }
        .step.active .step-number { background: var(--accent); }

        .timeline { display: grid; gap: 14px; }
        .timeline-item { display: grid; grid-template-columns: 42px 1fr; gap: 12px; position: relative; }
        .timeline-item::before { content: ""; position: absolute; left: 20px; top: 42px; bottom: -16px; width: 2px; background: var(--line); }
        .timeline-item:last-child::before { display: none; }
        .dot { width: 42px; height: 42px; border-radius: 999px; display: grid; place-items: center; background: #e2e8f0; color: var(--muted); font-weight: 950; border: 3px solid white; box-shadow: 0 6px 14px rgba(15,23,42,.1); }
        .timeline-item.done .dot { background: var(--primary); color: white; }
        .timeline-item.active .dot { background: var(--accent); color: white; box-shadow: 0 0 0 6px rgba(249,115,22,.14); }
        .timeline-card { border: 1px solid var(--line); border-radius: 8px; background: #f8fafc; padding: 13px; }
        .timeline-item.done .timeline-card { background: #f0fdfa; border-color: rgba(15,118,110,.25); }
        .timeline-item.active .timeline-card { background: #fff7ed; border-color: rgba(249,115,22,.38); }
        .timeline-title { font-weight: 950; margin-bottom: 4px; }
        .timeline-desc { color: var(--muted); line-height: 1.45; font-size: .92rem; }

        .section-title { color: var(--primary-dark); font-weight: 950; text-transform: uppercase; font-size: .84rem; margin-bottom: 10px; }
        .box { background: #f8fafc; border: 1px solid var(--line); border-radius: 8px; padding: 14px; margin-bottom: 16px; }
        .row { display: flex; justify-content: space-between; gap: 12px; padding: 9px 0; border-bottom: 1px solid var(--line); color: var(--muted); }
        .row:last-child { border-bottom: 0; }
        .row strong { color: var(--ink); text-align: right; }
        .item-row { display: grid; grid-template-columns: 1fr auto; gap: 12px; padding: 10px 0; border-bottom: 1px solid var(--line); }
        .item-row:last-child { border-bottom: 0; }
        .item-name { font-weight: 850; }
        .item-meta { color: var(--muted); font-size: .88rem; margin-top: 2px; }
        .item-price { color: var(--primary-dark); font-weight: 900; white-space: nowrap; }
        .total-card { background: linear-gradient(135deg, var(--primary-dark), var(--primary)); color: white; border-radius: 8px; padding: 18px; margin-bottom: 14px; }
        .total-card span { display: block; opacity: .82; font-weight: 800; font-size: .78rem; text-transform: uppercase; margin-bottom: 6px; }
        .total-card strong { display: block; font-family: "Courier New", monospace; font-size: 1.8rem; }
        .note { padding: 13px; border-radius: 8px; line-height: 1.5; font-weight: 750; background: #ffedd5; color: #9a3412; border-left: 4px solid var(--accent); }
        .note.ready, .note.done { background: #dcfce7; color: #166534; border-left-color: var(--success); }
        .actions { display: flex; gap: 10px; margin-top: 16px; }
        .btn { flex: 1; min-height: 46px; display: inline-flex; align-items: center; justify-content: center; padding: 0 14px; border: 0; border-radius: 8px; text-decoration: none; cursor: pointer; font-weight: 900; color: var(--ink); background: #e2e8f0; }
        .btn-primary { background: var(--primary); color: white; }

        @media (max-width: 900px) { .shell { grid-template-columns: 1fr; } .hero { display: block; } .order-chip { display: inline-block; margin-top: 14px; } }
        @media (max-width: 640px) { body { padding: 14px; } .steps { grid-template-columns: 1fr 1fr; } .actions { flex-direction: column; } .row { display: block; } .row strong { display: block; margin-top: 4px; text-align: left; } }
    </style>
</head>
<body>
    @php
        $status = $order->status;
        $rank = ['pending' => 1, 'preparing' => 2, 'ready' => 3, 'completed' => 4, 'cancelled' => 0][$status] ?? 1;
        $timeline = [
            ['rank' => 1, 'title' => 'Pesanan Diterima', 'desc' => 'Pesanan masuk ke sistem pada ' . ($order->ordered_at ? $order->ordered_at->format('d/m/Y H:i') : $order->created_at->format('d/m/Y H:i'))],
            ['rank' => 2, 'title' => 'Sedang Diproses', 'desc' => 'Tim dapur mulai menyiapkan pesanan Anda.'],
            ['rank' => 3, 'title' => 'Siap Diambil', 'desc' => 'Pesanan sudah siap diambil di counter.'],
            ['rank' => 4, 'title' => 'Selesai', 'desc' => $order->completed_at ? 'Transaksi selesai pada ' . $order->completed_at->format('d/m/Y H:i') : 'Menunggu konfirmasi selesai.'],
        ];
    @endphp

    <div class="page">
        <header class="hero">
            <div>
                <span class="eyebrow">Step 3 dari 4</span>
                <h1>Tracking Pesanan</h1>
                <p>Pantau posisi pesanan setelah konfirmasi dan pembayaran. Halaman ini otomatis diperbarui selama pesanan belum selesai.</p>
            </div>
            <div class="order-chip">#{{ $order->order_number }}</div>
        </header>

        <main class="shell">
            <section class="panel">
                <div class="steps">
                    <div class="step done"><div class="step-number">1</div><div class="step-title">Konfirmasi</div><div class="step-text">Data pesanan</div></div>
                    <div class="step {{ $status === 'pending' ? 'active' : 'done' }}"><div class="step-number">2</div><div class="step-title">Pembayaran</div><div class="step-text">Verifikasi</div></div>
                    <div class="step {{ $status === 'pending' ? '' : 'active' }}"><div class="step-number">3</div><div class="step-title">Tracking</div><div class="step-text">Status dapur</div></div>
                    <div class="step {{ $status === 'completed' ? 'done' : '' }}"><div class="step-number">4</div><div class="step-title">Invoice</div><div class="step-text">Struk akhir</div></div>
                </div>

                <div class="panel-body">
                    <div class="timeline">
                        @foreach($timeline as $index => $step)
                            @php
                                $state = $rank > $step['rank'] ? 'done' : ($rank === $step['rank'] ? 'active' : '');
                            @endphp
                            <div class="timeline-item {{ $state }}">
                                <div class="dot">{{ $index + 1 }}</div>
                                <div class="timeline-card">
                                    <div class="timeline-title">{{ $step['title'] }}</div>
                                    <div class="timeline-desc">{{ $step['desc'] }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <aside class="panel">
                <div class="panel-body">
                    <div class="total-card"><span>Total Pesanan</span><strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong></div>

                    <div class="section-title">Info Pesanan</div>
                    <div class="box">
                        <div class="row"><span>Nama</span><strong>{{ $order->customer_name }}</strong></div>
                        <div class="row"><span>Status</span><strong>{{ ucfirst($order->status) }}</strong></div>
                        <div class="row"><span>Item</span><strong>{{ $order->items->count() }} item</strong></div>
                    </div>

                    <div class="section-title">Detail Item</div>
                    <div class="box">
                        @foreach($order->items as $item)
                            <div class="item-row">
                                <div><div class="item-name">{{ $item->menuItem->name ?? 'Menu' }}</div><div class="item-meta">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</div></div>
                                <div class="item-price">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
                            </div>
                        @endforeach
                    </div>

                    @if ($order->status === 'ready')
                        <div class="note ready">Pesanan sudah siap. Silakan ambil di counter.</div>
                    @elseif ($order->status === 'completed')
                        <div class="note done">Terima kasih, transaksi sudah selesai.</div>
                    @else
                        <div class="note">Estimasi waktu tunggu 15-30 menit tergantung antrian.</div>
                    @endif

                    <div class="actions">
                        <button class="btn btn-primary" onclick="location.reload()">Segarkan</button>
                        <a class="btn" href="{{ route('order.receipt', $order->id) }}">Invoice</a>
                    </div>
                    <div class="actions">
                        <a class="btn" href="{{ route('menu.index') }}">Kembali Menu</a>
                    </div>
                </div>
            </aside>
        </main>
    </div>

    <script>
        @if (!in_array($order->status, ['completed', 'cancelled']))
            setInterval(function() { location.reload(); }, 10000);
        @endif
    </script>
</body>
</html>