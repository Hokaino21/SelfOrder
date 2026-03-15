<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Pesanan</title>
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

        .payment-card {
            background: white;
            border-radius: 15px;
            padding: 40px 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .header {
            text-align: center;
            margin-bottom: 35px;
        }

        .header-title {
            font-size: 2em;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .header-subtitle {
            color: #666;
            font-size: 0.95em;
        }

        .divider {
            border-top: 2px dashed #ddd;
            margin: 25px 0;
        }

        .amount-display {
            background: linear-gradient(135deg, var(--theme-start) 0%, var(--theme-end) 100%);
            color: white;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 30px;
        }

        .amount-label {
            font-size: 0.85em;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .amount-value {
            font-size: 2.5em;
            font-weight: 700;
            font-family: 'Courier New', monospace;
        }

        .order-summary {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 0.95em;
            color: #333;
        }

        .summary-row.total {
            border-top: 2px solid #ddd;
            padding-top: 12px;
            margin-top: 12px;
            font-weight: 700;
            color: var(--theme-main);
            font-size: 1.1em;
        }

        .section-title {
            font-size: 0.9em;
            font-weight: 700;
            text-transform: uppercase;
            color: #333;
            letter-spacing: 1.5px;
            margin: 25px 0 15px 0;
            padding-bottom: 8px;
            border-bottom: 1px solid #f0f0f0;
        }

        .payment-methods {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .payment-method {
            display: flex;
            align-items: center;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .payment-method:hover {
            border-color: var(--theme-main);
            background: #f9f9f9;
        }

        .payment-method input[type="radio"] {
            margin-right: 15px;
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .payment-method-content {
            flex: 1;
        }

        .payment-method-name {
            font-weight: 700;
            color: #333;
            margin-bottom: 3px;
        }

        .payment-method-desc {
            font-size: 0.85em;
            color: #666;
        }

        .payment-method-icon {
            font-size: 1.8em;
            margin-left: 10px;
        }

        .note-box {
            background: #e3f2fd;
            border-left: 4px solid var(--theme-main);
            padding: 12px;
            border-radius: 4px;
            margin: 25px 0;
            font-size: 0.9em;
            color: #1565c0;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 13px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.95em;
            text-decoration: none;
            text-align: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--theme-start) 0%, var(--theme-end) 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 191, 255, 0.4);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-secondary {
            background: #e0e0e0;
            color: #333;
        }

        .btn-secondary:hover {
            background: #d0d0d0;
        }

        @media (max-width: 600px) {
            .payment-card {
                padding: 25px 20px;
            }

            .header-title {
                font-size: 1.6em;
            }

            .amount-value {
                font-size: 2em;
            }

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
    <!-- SweetAlert2 Library -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="payment-card">
            <!-- Header -->
            <div class="header">
                <div class="header-title">💳 Pembayaran</div>
                <div class="header-subtitle">Pesanan #<?php echo e($order->order_number); ?></div>
            </div>

            <!-- Amount Display -->
            <div class="amount-display">
                <div class="amount-label">Total Pembayaran</div>
                <div class="amount-value">Rp <?php echo e(number_format($order->total_price, 0, ',', '.')); ?></div>
            </div>

            <div class="divider"></div>

            <!-- Order Summary -->
            <div class="section-title">📋 Ringkasan Pesanan</div>
            <div class="order-summary">
                <div class="summary-row">
                    <span>Nama Pemesan</span>
                    <span><?php echo e($order->customer_name); ?></span>
                </div>
                <div class="summary-row">
                    <span>Jumlah Item</span>
                    <span><?php echo e($order->items->count()); ?> item</span>
                </div>
                <div class="summary-row">
                    <span>Subtotal (90%)</span>
                    <span>Rp <?php echo e(number_format($order->total_price * 0.9, 0, ',', '.')); ?></span>
                </div>
                <div class="summary-row">
                    <span>Pajak (10%)</span>
                    <span>Rp <?php echo e(number_format($order->total_price * 0.1, 0, ',', '.')); ?></span>
                </div>
                <div class="summary-row total">
                    <span>Total</span>
                    <span>Rp <?php echo e(number_format($order->total_price, 0, ',', '.')); ?></span>
                </div>
            </div>

            <div class="divider"></div>

            <!-- Payment Methods -->
            <div class="section-title">💰 Metode Pembayaran</div>
            <form id="paymentForm" method="POST" action="<?php echo e(route('order.processPayment', $order->id)); ?>">
                <?php echo csrf_field(); ?>
                <div class="payment-methods">
                    <label class="payment-method">
                        <input type="radio" name="payment_method" value="cash" checked>
                        <div class="payment-method-content">
                            <div class="payment-method-name">Tunai</div>
                            <div class="payment-method-desc">Bayar saat pesanan diambil</div>
                        </div>
                        <div class="payment-method-icon">💵</div>
                    </label>

                    <label class="payment-method">
                        <input type="radio" name="payment_method" value="bank_transfer">
                        <div class="payment-method-content">
                            <div class="payment-method-name">Transfer Bank</div>
                            <div class="payment-method-desc">BRI: 0123456789 (Atas Nama Restoran)</div>
                        </div>
                        <div class="payment-method-icon">🏦</div>
                    </label>

                    <label class="payment-method">
                        <input type="radio" name="payment_method" value="ewallet">
                        <div class="payment-method-content">
                            <div class="payment-method-name">Dompet Digital</div>
                            <div class="payment-method-desc">GCash, GrabPay, Dana, OVO</div>
                        </div>
                        <div class="payment-method-icon">📱</div>
                    </label>
                </div>

                <div class="note-box">
                    ℹ️ Pesanan Anda akan kami proses. Gunakan nomor pesanan untuk tracking status.
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button type="submit" class="btn btn-primary" id="submitBtn">✓ Konfirmasi Pembayaran</button>
                    <a href="<?php echo e(route('order.receipt', $order->id)); ?>" class="btn btn-secondary" id="backBtn">← Kembali</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // debug helpers
        console.log('payment page script loaded');

        // helper to play a quick click/beep sound with Web Audio API
        function playClickSound() {
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.frequency.value = 1200;
                osc.type = 'square';
                gain.gain.setValueAtTime(0.2, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.1);
                osc.start(ctx.currentTime);
                osc.stop(ctx.currentTime + 0.1);
            } catch (err) {
                console.log('audio error', err);
            }
        }

        const form = document.getElementById('paymentForm');
        const submitBtn = document.getElementById('submitBtn');
        const backBtn = document.getElementById('backBtn');
        console.log('form element is', form);

        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            playClickSound();

            // give the user immediate confirmation that the click was registered
            // (this will appear even if the AJAX request later fails)
            if (window.Swal) {
                Swal.fire({ title: 'Transaksi berhasil', icon: 'success', timer: 1500, showConfirmButton: false });
            } else {
                alert('Transaksi berhasil');
            }

            const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            const orderId = <?php echo e($order->id); ?>;
            const paymentUrl = '<?php echo e(route("order.processPayment", $order->id)); ?>';
            console.log('will POST to', paymentUrl, 'method', paymentMethod);

            // Disable button and show loading
            submitBtn.disabled = true;
            submitBtn.textContent = '⏳ Memproses...';

            try {
                const response = await fetch(paymentUrl, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: JSON.stringify({
                        payment_method: paymentMethod
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    // also show a quick fallback alert in case the big modal was
                    // missed
                    if (window.Swal) {
                        Swal.fire({ title: 'Transaksi berhasil', icon: 'success', timer: 1500, showConfirmButton: false });
                    } else {
                        alert('Transaksi berhasil');
                    }
                    // Show detailed success notification
                    await Swal.fire({
                        title: '✅ Pembayaran Berhasil!',
                        html: `
                            <div style="text-align: left; font-size: 0.95em; background: white; padding: 20px; border-radius: 8px; max-height: 400px; overflow-y: auto;">
                                <div style="border-bottom: 2px solid #ddd; padding-bottom: 15px; margin-bottom: 15px;">
                                    <h3 style="margin: 0 0 10px 0; color: var(--theme-main);">📋 STRUK PEMBAYARAN</h3>
                                    <p style="margin: 5px 0; color: #666;"><strong>Nomor Pesanan:</strong> <span style="font-family: monospace; font-weight: bold; color: var(--theme-main);">${data.order_number}</span></p>
                                    <p style="margin: 5px 0; color: #666;"><strong>Nama Pemesan:</strong> ${data.customer_name}</p>
                                    <p style="margin: 5px 0; color: #666;"><strong>Metode:</strong> ${data.payment_method}</p>
                                </div>
                                
                                <div style="margin-bottom: 15px;">
                                    <p style="margin: 10px 0 5px 0; font-weight: 600; color: #333;">📦 Item Pesanan:</p>
                                    <div style="background: #f9f9f9; padding: 10px; border-radius: 6px; max-height: 150px; overflow-y: auto;">
                                        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div style="display: flex; justify-content: space-between; margin-bottom: 5px; font-size: 0.9em; color: #666;">
                                            <span><?php echo e($item->menuItem->name); ?> (x<?php echo e($item->quantity); ?>)</span>
                                            <span>Rp <?php echo e(number_format($item->price * $item->quantity, 0, ',', '.')); ?></span>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>

                                <div style="border-top: 2px solid #ddd; padding-top: 15px;">
                                    <div style="display: flex; justify-content: space-between; font-weight: 700; color: var(--theme-main); font-size: 1.1em;">
                                        <span>💰 Total:</span>
                                        <span>${data.total_price}</span>
                                    </div>
                                    <p style="margin: 10px 0 0 0; color: #28a745; font-size: 0.9em;">✅ Pembayaran diterima! Pesanan sedang diproses.</p>
                                </div>
                            </div>
                        `,
                        icon: 'success',
                        confirmButtonColor: '#00BFFF',
                        confirmButtonText: 'Lihat Struk Lengkap',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });

                    // Redirect to receipt
                    window.location.href = `/order/${orderId}/receipt`;
                } else {
                    throw new Error(data.message || 'Gagal memproses pembayaran');
                }
            } catch (error) {
                submitBtn.disabled = false;
                submitBtn.textContent = '✓ Konfirmasi Pembayaran';

                const message = error.message || 'Terjadi kesalahan saat memproses pembayaran';
                if (window.Swal) {
                    Swal.fire({
                        title: '❌ Pembayaran Gagal',
                        text: message,
                        icon: 'error',
                        confirmButtonColor: '#00BFFF'
                    });
                } else {
                    alert('❌ Pembayaran Gagal: ' + message);
                }
            }
        });
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\c7\resources\views/order/payment.blade.php ENDPATH**/ ?>