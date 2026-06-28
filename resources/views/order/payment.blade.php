<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Pesanan</title>
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
            --danger: #dc2626;
            --success: #16a34a;
            --warning-bg: #ffedd5;
            --shadow: 0 18px 45px rgba(15, 23, 42, 0.14);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            padding: 24px;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: var(--ink);
            background:
                linear-gradient(135deg, rgba(23, 32, 42, 0.94), rgba(17, 94, 89, 0.9)),
                url("https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=1800&q=80") center/cover fixed;
        }

        .page { width: min(1120px, 100%); margin: 0 auto; }
        .hero { color: white; margin-bottom: 22px; display: flex; justify-content: space-between; gap: 18px; align-items: flex-end; }
        .eyebrow { display: inline-block; padding: 7px 12px; border: 1px solid rgba(255,255,255,.28); border-radius: 999px; background: rgba(255,255,255,.14); font-weight: 800; font-size: .84rem; margin-bottom: 12px; }
        h1 { font-size: clamp(2rem, 5vw, 3.8rem); line-height: 1; margin-bottom: 10px; }
        .hero p { color: rgba(255,255,255,.84); line-height: 1.6; max-width: 620px; }
        .order-chip { background: rgba(255,255,255,.16); border: 1px solid rgba(255,255,255,.32); border-radius: 8px; padding: 12px 14px; color: white; font-weight: 900; white-space: nowrap; }

        .shell { display: grid; grid-template-columns: minmax(0, 1fr) 360px; gap: 18px; align-items: start; }
        .panel { background: rgba(255,255,255,.97); border: 1px solid rgba(255,255,255,.72); border-radius: 8px; box-shadow: var(--shadow); overflow: hidden; }
        .panel-body { padding: 20px; }

        .steps { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; padding: 16px; border-bottom: 1px solid var(--line); background: #f8fafc; }
        .step { min-height: 72px; padding: 10px; border: 1px solid var(--line); border-radius: 8px; background: white; }
        .step-number { width: 26px; height: 26px; display: grid; place-items: center; border-radius: 999px; background: #e2e8f0; color: var(--muted); font-weight: 900; font-size: .82rem; margin-bottom: 8px; }
        .step-title { font-weight: 900; font-size: .9rem; color: var(--ink); }
        .step-text { color: var(--muted); font-size: .78rem; margin-top: 3px; }
        .step.done .step-number, .step.active .step-number { background: var(--primary); color: white; }
        .step.active { border-color: rgba(249,115,22,.55); box-shadow: inset 0 0 0 2px rgba(249,115,22,.12); }
        .step.active .step-number { background: var(--accent); }

        .section-title { font-size: .86rem; letter-spacing: 0; text-transform: uppercase; color: var(--primary-dark); font-weight: 900; margin-bottom: 12px; }
        .payment-methods { display: grid; gap: 10px; }
        .payment-method { display: grid; grid-template-columns: auto 1fr; gap: 12px; align-items: start; padding: 14px; border: 2px solid var(--line); border-radius: 8px; cursor: pointer; transition: border-color .2s ease, background .2s ease, transform .2s ease; }
        .payment-method:hover { border-color: var(--primary); background: #f0fdfa; transform: translateY(-1px); }
        .payment-method input { width: 20px; height: 20px; margin-top: 2px; accent-color: var(--primary); }
        .payment-method-name { font-weight: 900; margin-bottom: 3px; }
        .payment-method-desc { color: var(--muted); font-size: .9rem; line-height: 1.45; }
        .note-box { margin-top: 16px; padding: 13px; border-radius: 8px; background: var(--warning-bg); color: #9a3412; border-left: 4px solid var(--accent); line-height: 1.5; font-size: .92rem; }

        .invoice { background: #f8fafc; border: 1px solid var(--line); border-radius: 8px; padding: 16px; }
        .amount-display { background: linear-gradient(135deg, var(--primary-dark), var(--primary)); color: white; padding: 18px; border-radius: 8px; margin-bottom: 14px; }
        .amount-label { opacity: .82; font-weight: 800; font-size: .78rem; text-transform: uppercase; margin-bottom: 6px; }
        .amount-value { font-size: 2rem; font-weight: 950; font-family: "Courier New", monospace; }
        .summary-row, .item-row { display: flex; justify-content: space-between; gap: 12px; padding: 9px 0; border-bottom: 1px solid var(--line); color: var(--muted); font-size: .94rem; }
        .summary-row strong, .item-row strong { color: var(--ink); }
        .summary-row.total { border-bottom: 0; border-top: 2px solid var(--line); margin-top: 8px; padding-top: 12px; color: var(--primary-dark); font-size: 1.1rem; font-weight: 900; }
        .item-list { margin-top: 12px; }
        .item-row:last-child { border-bottom: 0; }

        .actions { display: flex; gap: 10px; margin-top: 18px; }
        .btn { flex: 1; min-height: 48px; display: inline-flex; align-items: center; justify-content: center; padding: 0 16px; border: 0; border-radius: 8px; text-decoration: none; cursor: pointer; font-weight: 900; font-size: .95rem; transition: transform .2s ease, box-shadow .2s ease, background .2s ease; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 12px 24px rgba(15,118,110,.24); }
        .btn-primary:disabled { opacity: .6; cursor: not-allowed; }
        .btn-secondary { background: #e2e8f0; color: var(--ink); }
        .btn-secondary:hover { background: #cbd5e1; }

        @media (max-width: 900px) { .shell { grid-template-columns: 1fr; } .hero { display: block; } .order-chip { display: inline-block; margin-top: 14px; } }
        @media (max-width: 640px) { body { padding: 14px; } .steps { grid-template-columns: 1fr 1fr; } .actions { flex-direction: column; } .amount-value { font-size: 1.55rem; } }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</head>
<body>
    <div class="page">
        <header class="hero">
            <div>
                <span class="eyebrow">Step 2 dari 4</span>
                <h1>Pembayaran</h1>
                <p>Konfirmasi metode pembayaran agar pesanan masuk ke alur tracking dan invoice.</p>
            </div>
            <div class="order-chip">#{{ $order->order_number }}</div>
        </header>

        <main class="shell">
            <section class="panel">
                <div class="steps">
                    <div class="step done"><div class="step-number">1</div><div class="step-title">Konfirmasi</div><div class="step-text">Data pesanan</div></div>
                    <div class="step active"><div class="step-number">2</div><div class="step-title">Pembayaran</div><div class="step-text">Pilih metode</div></div>
                    <div class="step"><div class="step-number">3</div><div class="step-title">Tracking</div><div class="step-text">Pantau status</div></div>
                    <div class="step"><div class="step-number">4</div><div class="step-title">Invoice</div><div class="step-text">Struk akhir</div></div>
                </div>
                <div class="panel-body">
                    <div class="section-title">Metode Pembayaran</div>
                    <form id="paymentForm" method="POST" action="{{ route('order.processPayment', $order->id) }}">
                        @csrf
                        <div class="payment-methods">
                            <label class="payment-method">
                                <input type="radio" name="payment_method" value="cash" checked>
                                <div><div class="payment-method-name">Tunai di Counter</div><div class="payment-method-desc">Bayar saat pesanan diambil. Simpan nomor pesanan untuk petugas.</div></div>
                            </label>
                            <label class="payment-method">
                                <input type="radio" name="payment_method" value="bank_transfer">
                                <div><div class="payment-method-name">Transfer Bank</div><div class="payment-method-desc">BRI 0123456789 a.n. Restoran. Tunjukkan bukti saat pengambilan.</div></div>
                            </label>
                            <label class="payment-method">
                                <input type="radio" name="payment_method" value="ewallet">
                                <div><div class="payment-method-name">Dompet Digital</div><div class="payment-method-desc">Dana, OVO, GrabPay, atau metode QR yang tersedia di counter.</div></div>
                            </label>
                        </div>

                        <div class="note-box">Setelah pembayaran dikonfirmasi, Anda akan diarahkan ke invoice dan dapat membuka tracking pesanan.</div>

                        <div class="actions">
                            <button type="submit" class="btn btn-primary" id="submitBtn">Konfirmasi Pembayaran</button>
                            <a href="{{ route('order.receipt', $order->id) }}" class="btn btn-secondary">Lihat Invoice</a>
                        </div>
                    </form>
                </div>
            </section>

            <aside class="panel">
                <div class="panel-body">
                    <div class="amount-display">
                        <div class="amount-label">Total Pembayaran</div>
                        <div class="amount-value">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                    </div>
                    <div class="invoice">
                        <div class="section-title">Ringkasan Invoice</div>
                        <div class="summary-row"><span>Nama</span><strong>{{ $order->customer_name }}</strong></div>
                        <div class="summary-row"><span>Item</span><strong>{{ $order->items->count() }} item</strong></div>
                        <div class="item-list">
                            @foreach($order->items as $item)
                                <div class="item-row"><span>{{ $item->menuItem->name ?? 'Menu' }} x{{ $item->quantity }}</span><strong>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</strong></div>
                            @endforeach
                        </div>
                        <div class="summary-row"><span>Subtotal</span><strong>Rp {{ number_format($order->total_price * 0.9, 0, ',', '.') }}</strong></div>
                        <div class="summary-row"><span>Pajak 10%</span><strong>Rp {{ number_format($order->total_price * 0.1, 0, ',', '.') }}</strong></div>
                        <div class="summary-row total"><span>Total</span><span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span></div>
                    </div>
                </div>
            </aside>
        </main>
    </div>

    <script>
        function playClickSound() {
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.frequency.value = 880;
                osc.type = 'sine';
                gain.gain.setValueAtTime(0.16, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.1);
                osc.start(ctx.currentTime);
                osc.stop(ctx.currentTime + 0.1);
            } catch (err) {}
        }

        document.getElementById('paymentForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            playClickSound();

            const submitBtn = document.getElementById('submitBtn');
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Memproses...';

            try {
                const response = await fetch('{{ route("order.processPayment", $order->id) }}', {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ payment_method: paymentMethod })
                });
                const data = await response.json();

                if (!response.ok || !data.success) {
                    throw new Error(data.message || 'Gagal memproses pembayaran');
                }

                if (window.Swal) {
                    await Swal.fire({
                        title: 'Pembayaran Berhasil',
                        text: `Invoice ${data.order_number} siap dibuka.`,
                        icon: 'success',
                        confirmButtonText: 'Buka Invoice',
                        confirmButtonColor: '#0f766e',
                        allowOutsideClick: false
                    });
                }

                window.location.href = '{{ route('order.receipt', $order->id) }}';
            } catch (error) {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Konfirmasi Pembayaran';
                if (window.Swal) {
                    Swal.fire({ title: 'Pembayaran Gagal', text: error.message, icon: 'error', confirmButtonColor: '#0f766e' });
                } else {
                    alert('Pembayaran gagal: ' + error.message);
                }
            }
        });
    </script>
</body>
</html>