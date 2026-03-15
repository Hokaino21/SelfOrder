<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemesanan - Restoran</title>
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
            max-width: 800px;
            width: 100%;
        }

        .form-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 2em;
        }

        .form-subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 1em;
        }

        .form-section {
            margin-bottom: 25px;
        }

        .form-section h3 {
            color: #667eea;
            font-size: 1.2em;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1em;
            font-family: inherit;
            transition: all 0.3s ease;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        .order-items {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background: white;
            border-radius: 6px;
            margin-bottom: 8px;
            border-left: 4px solid #667eea;
        }

        .item-name {
            font-weight: 600;
            color: #333;
        }

        .item-detail {
            color: #666;
            font-size: 0.9em;
        }

        .item-price {
            font-weight: 700;
            color: #667eea;
        }

        .order-summary {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            color: #333;
        }

        .summary-row.total {
            font-size: 1.3em;
            font-weight: 700;
            border-top: 2px solid #ddd;
            padding-top: 10px;
            color: #667eea;
        }

        .button-group {
            display: flex;
            gap: 10px;
        }

        button {
            flex: 1;
            padding: 15px;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1.1em;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .back-btn {
            background: #e0e0e0;
            color: #333;
        }

        .back-btn:hover {
            background: #d0d0d0;
        }

        .submit-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .submit-btn:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .error-message {
            color: #ff6b6b;
            font-size: 0.9em;
            margin-top: 5px;
        }

        @media (max-width: 600px) {
            .form-card {
                padding: 20px;
            }

            h1 {
                font-size: 1.5em;
            }

            .button-group {
                flex-direction: column;
            }

            .order-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .summary-row {
                flex-direction: column;
                gap: 5px;
            }
        }

        .required {
            color: #ff6b6b;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-card">
            <h1>📝 Konfirmasi Pesanan</h1>
            <p class="form-subtitle">Silakan isi data diri Anda untuk melanjutkan pesanan</p>

            <form id="orderForm" method="POST" action="{{ route('order.store') }}" onsubmit="prepareForm(event)">
                @csrf

                <!-- Data Pemesan -->
                <div class="form-section">
                    <h3>👤 Data Pemesan</h3>

                    <div class="form-group">
                        <label for="customer_name">Nama Lengkap <span class="required">*</span></label>
                        <input type="text" id="customer_name" name="customer_name" required placeholder="Masukkan nama Anda">
                        @error('customer_name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="customer_phone">Nomor Telepon</label>
                        <input type="tel" id="customer_phone" name="customer_phone" placeholder="Masukkan nomor telepon Anda (+62)">
                        @error('customer_phone')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="notes">Catatan Khusus (Opsional)</label>
                        <textarea id="notes" name="notes" placeholder="Contoh: Tidak pakai sambal, extra bumbu, dll."></textarea>
                        @error('notes')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Ringkasan Pesanan -->
                <div class="form-section">
                    <h3>🛒 Ringkasan Pesanan</h3>
                    <div id="orderItemsDisplay" class="order-items"></div>
                </div>

                <!-- Total Harga -->
                <div class="order-summary">
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span id="subtotal">Rp 0</span>
                    </div>
                    <div class="summary-row">
                        <span>Pajak (10%):</span>
                        <span id="tax">Rp 0</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total Pesanan:</span>
                        <span id="total">Rp 0</span>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="button-group">
                    <button type="button" class="back-btn" onclick="history.back()">← Kembali</button>
                    <button type="submit" class="submit-btn">Selesaikan Pesanan ✓</button>
                </div>
            </form>
        </div>
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

            // Build cart HTML
            let itemIndex = 0;
            for (const id in cart) {
                const item = cart[id];
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;

                html += `
                    <div class="order-item">
                        <div>
                            <div class="item-name">${item.name}</div>
                            <div class="item-detail">${item.quantity} x Rp ${(item.price).toLocaleString('id-ID')}</div>
                        </div>
                        <div class="item-price">Rp ${(itemTotal).toLocaleString('id-ID')}</div>
                    </div>
                `;

                // Add hidden form fields for each cart item
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
            
            // Remove old cartInput if exists
            const oldInput = document.getElementById('cartInput');
            if (oldInput) {
                oldInput.remove();
            }

            // Calculate tax and total
            const tax = subtotal * 0.1;
            const total = subtotal + tax;

            document.getElementById('subtotal').textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
            document.getElementById('tax').textContent = `Rp ${Math.round(tax).toLocaleString('id-ID')}`;
            document.getElementById('total').textContent = `Rp ${Math.round(total).toLocaleString('id-ID')}`;
        }

        // Load order on page load
        displayOrder();

        // Auto-format phone number
        document.getElementById('customer_phone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.startsWith('62')) {
                value = '+' + value;
            } else if (value.startsWith('0')) {
                value = '+62' + value.substring(1);
            }
            e.target.value = value;
        });

        // show confirmation popup when user clicks "Selesaikan Pesanan"
        const createForm = document.querySelector('form');
        createForm.addEventListener('submit', function(evt) {
            evt.preventDefault();
            // feedback first (popup or simple alert)
            if (window.Swal) {
                Swal.fire({ title: 'Pesanan berhasil dibuat', icon: 'success', timer: 1500, showConfirmButton: false });
            } else {
                alert('Pesanan berhasil dibuat');
            }
            // submit after short delay so user sees notification
            setTimeout(() => createForm.submit(), 1600);
        });
    </script>
</body>
</html>
