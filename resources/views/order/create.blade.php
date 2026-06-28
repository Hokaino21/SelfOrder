<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pesanan</title>
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
        .hero-chip { background: rgba(255,255,255,.16); border: 1px solid rgba(255,255,255,.32); border-radius: 8px; padding: 12px 14px; color: white; font-weight: 900; white-space: nowrap; }

        .shell { display: grid; grid-template-columns: minmax(0, 1fr) 360px; gap: 18px; align-items: start; }
        .panel { background: rgba(255,255,255,.98); border-radius: 8px; box-shadow: var(--shadow); overflow: hidden; }
        .panel-body { padding: 20px; }

        .steps { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; padding: 16px; border-bottom: 1px solid var(--line); background: #f8fafc; }
        .step { min-height: 72px; padding: 10px; border: 1px solid var(--line); border-radius: 8px; background: white; }
        .step-number { width: 26px; height: 26px; display: grid; place-items: center; border-radius: 999px; background: #e2e8f0; color: var(--muted); font-weight: 900; font-size: .82rem; margin-bottom: 8px; }
        .step-title { font-weight: 900; font-size: .9rem; }
        .step-text { color: var(--muted); font-size: .78rem; margin-top: 3px; }
        .step.active { border-color: rgba(249,115,22,.55); box-shadow: inset 0 0 0 2px rgba(249,115,22,.12); }
        .step.active .step-number { background: var(--accent); color: white; }

        .section-title { color: var(--primary-dark); font-weight: 950; text-transform: uppercase; font-size: .84rem; margin-bottom: 12px; }
        .form-section { margin-bottom: 22px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 8px; color: var(--ink); font-weight: 850; }
        input, textarea { width: 100%; padding: 13px 14px; border: 2px solid var(--line); border-radius: 8px; font-size: 1rem; font-family: inherit; color: var(--ink); background: #ffffff; transition: border-color .2s ease, box-shadow .2s ease; }
        input:focus, textarea:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 4px rgba(15,118,110,.14); }
        textarea { resize: vertical; min-height: 96px; line-height: 1.5; }
        .required { color: var(--danger); }
        .error-message { color: var(--danger); font-size: .9rem; margin-top: 5px; }

        .order-items, .summary-box { background: #f8fafc; border: 1px solid var(--line); border-radius: 8px; padding: 14px; }
        .order-item { display: flex; justify-content: space-between; gap: 12px; padding: 12px; background: white; border: 1px solid var(--line); border-left: 4px solid var(--primary); border-radius: 8px; margin-bottom: 10px; }
        .order-item:last-child { margin-bottom: 0; }
        .item-name { font-weight: 900; color: var(--ink); }
        .item-detail { color: var(--muted); font-size: .92rem; margin-top: 3px; }
        .item-price { font-weight: 950; color: var(--primary-dark); white-space: nowrap; }
        .summary-row { display: flex; justify-content: space-between; gap: 12px; padding: 9px 0; border-bottom: 1px solid var(--line); color: var(--muted); }
        .summary-row:last-child { border-bottom: 0; }
        .summary-row strong { color: var(--ink); }
        .summary-row.total { color: var(--primary-dark); font-size: 1.15rem; font-weight: 950; border-top: 2px solid var(--line); margin-top: 8px; padding-top: 12px; }

        .actions { display: flex; gap: 10px; margin-top: 18px; }
        button, .btn { flex: 1; min-height: 48px; display: inline-flex; align-items: center; justify-content: center; padding: 0 16px; border: 0; border-radius: 8px; text-decoration: none; cursor: pointer; font-weight: 900; font-size: .96rem; transition: transform .2s ease, box-shadow .2s ease, background .2s ease; }
        .submit-btn { background: var(--primary); color: white; }
        .submit-btn:hover { transform: translateY(-2px); background: var(--primary-dark); box-shadow: 0 12px 24px rgba(15,118,110,.24); }
        .back-btn { background: #e2e8f0; color: var(--ink); }
        .back-btn:hover { background: #cbd5e1; }
        .note-help { margin-top: 8px; color: var(--muted); font-size: .88rem; line-height: 1.45; }

        @media (max-width: 900px) { .shell { grid-template-columns: 1fr; } .hero { display: block; } .hero-chip { display: inline-block; margin-top: 14px; } }
        @media (max-width: 640px) { body { padding: 14px; } .steps { grid-template-columns: 1fr 1fr; } .actions, .order-item, .summary-row { flex-direction: column; } .item-price { white-space: normal; } }
    </style>
</head>
<body>
    <div class="page">
        <header class="hero">
            <div>
                <span class="eyebrow">Step 1 dari 4</span>
                <h1>Konfirmasi Pesanan</h1>
                <p>Isi data pemesan dan catatan khusus sebelum lanjut ke pembayaran. Catatan ini akan tampil di admin dan invoice.</p>
            </div>
            <div class="hero-chip">Self Order</div>
        </header>

        <main class="shell">
            <section class="panel">
                <div class="steps">
                    <div class="step active"><div class="step-number">1</div><div class="step-title">Konfirmasi</div><div class="step-text">Data pesanan</div></div>
                    <div class="step"><div class="step-number">2</div><div class="step-title">Pembayaran</div><div class="step-text">Pilih metode</div></div>
                    <div class="step"><div class="step-number">3</div><div class="step-title">Tracking</div><div class="step-text">Pantau status</div></div>
                    <div class="step"><div class="step-number">4</div><div class="step-title">Invoice</div><div class="step-text">Struk akhir</div></div>
                </div>

                <div class="panel-body">
                    <form id="orderForm" method="POST" action="{{ route('order.store') }}">
                        @csrf
                        <div class="form-section">
                            <div class="section-title">Data Pemesan</div>
                            <div class="form-group">
                                <label for="customer_name">Nama Lengkap <span class="required">*</span></label>
                                <input type="text" id="customer_name" name="customer_name" required placeholder="Masukkan nama Anda" value="{{ old('customer_name') }}">
                                @error('customer_name')<div class="error-message">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label for="customer_phone">Nomor Telepon</label>
                                <input type="tel" id="customer_phone" name="customer_phone" placeholder="Masukkan nomor telepon Anda (+62)" value="{{ old('customer_phone') }}">
                                @error('customer_phone')<div class="error-message">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label for="notes">Catatan Khusus (Opsional)</label>
                                <textarea id="notes" name="notes" placeholder="Contoh: Tidak pakai sambal, extra bumbu, dipisah saus, dll.">{{ old('notes') }}</textarea>
                                <div class="note-help">Catatan ini akan ikut muncul di dashboard admin dan invoice pesanan.</div>
                                @error('notes')<div class="error-message">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="actions">
                            <button type="button" class="back-btn" onclick="history.back()">Kembali</button>
                            <button type="submit" class="submit-btn">Selesaikan Pesanan</button>
                        </div>
                    </form>
                </div>
            </section>

            <aside class="panel">
                <div class="panel-body">
                    <div class="section-title">Ringkasan Pesanan</div>
                    <div id="orderItemsDisplay" class="order-items"></div>

                    <div class="summary-box" style="margin-top:16px;">
                        <div class="summary-row"><span>Subtotal</span><strong id="subtotal">Rp 0</strong></div>
                        <div class="summary-row"><span>Pajak (10%)</span><strong id="tax">Rp 0</strong></div>
                        <div class="summary-row total"><span>Total Pesanan</span><span id="total">Rp 0</span></div>
                    </div>
                </div>
            </aside>
        </main>
    </div>

    <script>
        let cart = JSON.parse(localStorage.getItem('cart')) || {};

        function displayOrder() {
            const orderItemsDisplay = document.getElementById('orderItemsDisplay');
            let subtotal = 0;
            let html = '';

            if (Object.keys(cart).length === 0) {
                window.location.href = '{{ route('menu.index') }}';
                return;
            }

            let itemIndex = 0;
            for (const id in cart) {
                const item = cart[id];
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;

                html += `
                    <div class="order-item">
                        <div>
                            <div class="item-name">${item.name}</div>
                            <div class="item-detail">${item.quantity} x Rp ${item.price.toLocaleString('id-ID')}</div>
                        </div>
                        <div class="item-price">Rp ${itemTotal.toLocaleString('id-ID')}</div>
                    </div>
                `;

                const menuItemIdField = document.createElement('input');
                menuItemIdField.type = 'hidden';
                menuItemIdField.name = `cart[${itemIndex}][menu_item_id]`;
                menuItemIdField.value = id;

                const quantityField = document.createElement('input');
                quantityField.type = 'hidden';
                quantityField.name = `cart[${itemIndex}][quantity]`;
                quantityField.value = item.quantity;

                document.getElementById('orderForm').appendChild(menuItemIdField);
                document.getElementById('orderForm').appendChild(quantityField);
                itemIndex++;
            }

            orderItemsDisplay.innerHTML = html;
            const tax = subtotal * 0.1;
            const total = subtotal + tax;
            document.getElementById('subtotal').textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
            document.getElementById('tax').textContent = `Rp ${Math.round(tax).toLocaleString('id-ID')}`;
            document.getElementById('total').textContent = `Rp ${Math.round(total).toLocaleString('id-ID')}`;
        }

        displayOrder();

        document.getElementById('customer_phone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.startsWith('62')) {
                value = '+' + value;
            } else if (value.startsWith('0')) {
                value = '+62' + value.substring(1);
            }
            e.target.value = value;
        });
    </script>
</body>
</html>