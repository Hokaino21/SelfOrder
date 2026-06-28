<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Restoran</title>
    <style>
        :root {
            --theme-start: #0f766e;
            --theme-end: #115e59;
            --theme-main: #0f766e;
            --theme-accent: #f97316;
            --theme-ink: #17202a;
            --theme-muted: #657386;
            --theme-line: #dbe3ee;
            --theme-bg: #f4f7fb;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--theme-bg);
            color: var(--theme-ink);
        }

        .header {
            background: linear-gradient(135deg, var(--theme-ink) 0%, var(--theme-end) 100%);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.18);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-title {
            font-size: 1.5em;
            font-weight: 700;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid white;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 25px 20px;
        }

        .stats-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.08);
            border: 1px solid var(--theme-line);
            border-top: 4px solid var(--theme-main);
            text-align: center;
        }

        .stat-icon {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 2em;
            font-weight: 700;
            color: var(--theme-main);
            margin-bottom: 5px;
        }

        .stat-label {
            color: var(--theme-muted);
            font-size: 0.9em;
        }

        .section-title {
            font-size: 1.5em;
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--theme-ink);
        }

        .table-wrapper {
            background: white;
            border-radius: 8px;
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.08);
            border: 1px solid var(--theme-line);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f8fafc;
            border-bottom: 2px solid var(--theme-line);
        }

        th {
            padding: 15px;
            text-align: left;
            font-weight: 700;
            color: var(--theme-ink);
            font-size: 0.95em;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid var(--theme-line);
            font-size: 0.95em;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        .order-number {
            font-family: 'Courier New', monospace;
            font-weight: 700;
            color: var(--theme-main);
        }

        .customer-info {
            display: flex;
            flex-direction: column;
        }

        .customer-name {
            font-weight: 600;
            color: var(--theme-ink);
        }

        .customer-phone {
            font-size: 0.85em;
            color: var(--theme-muted);
        }

        .status-select {
            padding: 8px 12px;
            border: 2px solid var(--theme-line);
            border-radius: 6px;
            font-size: 0.9em;
            cursor: pointer;
            background: white;
            transition: all 0.3s ease;
        }

        .status-select:focus {
            outline: none;
            border-color: var(--theme-main);
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.14);
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
        }

        .status-pending {
            background: #ffedd5;
            color: #9a3412;
        }

        .status-preparing {
            background: #ccfbf1;
            color: #115e59;
        }

        .status-ready {
            background: #dcfce7;
            color: #166534;
        }

        .status-completed {
            background: #dcfce7;
            color: #166534;
        }

        .status-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .items-count {
            background: #eef6f5;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 600;
            display: inline-block;
        }

        .price {
            font-weight: 700;
            color: var(--theme-main);
        }

        .timestamp {
            font-size: 0.85em;
            color: var(--theme-muted);
        }

        .delete-btn {
            padding: 6px 12px;
            background: #dc2626;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.85em;
            transition: all 0.3s ease;
        }

        .delete-btn:hover {
            background: #b91c1c;
            transform: scale(1.05);
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 25px;
            padding-top: 20px;
        }

        .pagination a,
        .pagination span {
            padding: 8px 12px;
            border-radius: 6px;
            background: white;
            color: var(--theme-main);
            text-decoration: none;
            border: 1px solid #ddd;
            transition: all 0.3s ease;
        }

        .pagination a:hover {
            background: var(--theme-main);
            color: white;
            border-color: var(--theme-main);
        }

        .pagination .active {
            background: var(--theme-main);
            color: white;
            border-color: var(--theme-main);
        }

        .success-message {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            border-left: 4px solid var(--theme-main);
        }

        .highlight-row {
            animation: highlightPulse 0.6s ease;
        }

        @keyframes highlightPulse {
            0% { background-color: #fff3cd; }
            100% { background-color: transparent; }
        }

        /* Payment notification styles */
        .payment-popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: linear-gradient(135deg, var(--theme-main) 0%, var(--theme-accent) 100%);
            color: white;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            z-index: 2000;
            animation: popupEntrance 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            backdrop-filter: blur(10px);
            text-align: center;
            min-width: 300px;
        }

        .payment-popup h2 {
            font-size: 2.5em;
            margin: 0 0 10px 0;
            font-weight: 700;
        }

        .payment-popup p {
            font-size: 1.2em;
            margin: 5px 0;
            opacity: 0.95;
        }

        .payment-popup .order-info {
            font-size: 0.9em;
            opacity: 0.85;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.3);
        }

        .payment-popup .confetti-icon {
            font-size: 3em;
            animation: bounce 0.6s ease;
            display: inline-block;
            margin-bottom: 10px;
        }

        @keyframes popupEntrance {
            0% {
                opacity: 0;
                transform: translate(-50%, -50%) scale(0.3) rotate(-10deg);
            }
            50% {
                transform: translate(-50%, -50%) scale(1.1) rotate(5deg);
            }
            100% {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1) rotate(0deg);
            }
        }

        @keyframes popupExit {
            0% {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1) rotate(0deg);
            }
            100% {
                opacity: 0;
                transform: translate(-50%, -50%) scale(0.3) rotate(-10deg);
            }
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        /* Confetti canvas */
        #confetti-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1999;
        }

        /* Overlay untuk modal payment */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1998;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }

        @media (max-width: 1024px) {
            .stats-section {
                grid-template-columns: repeat(2, 1fr);
            }

            table {
                font-size: 0.85em;
            }

            th, td {
                padding: 12px;
            }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .stats-section {
                grid-template-columns: 1fr;
            }

            .table-wrapper {
                overflow-x: auto;
            }

            table {
                min-width: 800px;
            }

        }
    </style>
</head>
<body>
    <!-- Canvas untuk confetti animation -->
    <canvas id="confetti-canvas"></canvas>

    <!-- debug counter -->
    <div id="refreshCounter" style="position:fixed;bottom:20px;left:20px;background:#fff;padding:5px;border:1px solid #ccc;border-radius:4px;font-size:0.85em;z-index:1000;">Updates: 0</div>

    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <div>🏪</div>
            <div class="header-title">Dashboard Admin - Kelola Pesanan</div>
        </div>
        <form method="POST" action="<?php echo e(route('admin.logout')); ?>" style="margin: 0;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="logout-btn">🚪 Logout</button>
        </form>
    </div>

    <div class="container">
        <!-- Success Message -->
        <?php if(session('success')): ?>
        <div class="success-message">
            ✅ <?php echo e(session('success')); ?>

        </div>
        <?php endif; ?>

        <!-- Stats Section -->
        <div class="stats-section">
            <div class="stat-card">
                <div class="stat-icon">⏳</div>
                <div class="stat-value"><?php echo e($stats['pending']); ?></div>
                <div class="stat-label">Menunggu Pembayaran</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">👨‍🍳</div>
                <div class="stat-value"><?php echo e($stats['preparing']); ?></div>
                <div class="stat-label">Sedang Diproses</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">✓</div>
                <div class="stat-value"><?php echo e($stats['ready']); ?></div>
                <div class="stat-label">Siap Diambil</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🎉</div>
                <div class="stat-value"><?php echo e($stats['completed']); ?></div>
                <div class="stat-label">Selesai</div>
            </div>
        </div>

        <!-- Orders Table -->
        <h2 class="section-title">📋 Daftar Pesanan</h2>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No. Pesanan</th>
                        <th>Pemesan</th>
                        <th>Item</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Waktu Pesanan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr data-order-id="<?php echo e($order->id); ?>">
                        <td class="order-number"><?php echo e($order->order_number); ?></td>
                        <td>
                            <div class="customer-info">
                                <span class="customer-name"><?php echo e($order->customer_name); ?></span>
                                <?php if($order->customer_phone): ?>
                                <span class="customer-phone"><?php echo e($order->customer_phone); ?></span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <span class="items-count"><?php echo e($order->items->count()); ?> item</span>
                        </td>
                        <td class="price">Rp <?php echo e(number_format($order->total_price, 0, ',', '.')); ?></td>
                        <td>
                            <select 
                                class="status-select status-<?php echo e($order->status); ?>" 
                                onchange="updateStatus(<?php echo e($order->id); ?>, this.value)"
                            >
                                <option value="pending" <?php echo e($order->status === 'pending' ? 'selected' : ''); ?>>⏳ Menunggu</option>
                                <option value="preparing" <?php echo e($order->status === 'preparing' ? 'selected' : ''); ?>>👨‍🍳 Diproses</option>
                                <option value="ready" <?php echo e($order->status === 'ready' ? 'selected' : ''); ?>>✓ Siap</option>
                                <option value="completed" <?php echo e($order->status === 'completed' ? 'selected' : ''); ?>>✓ Selesai</option>
                                <option value="cancelled" <?php echo e($order->status === 'cancelled' ? 'selected' : ''); ?>>❌ Batal</option>
                            </select>
                        </td>
                        <td class="timestamp"><?php echo e($order->created_at->format('d/m/Y H:i')); ?></td>
                        <td>
                            <button class="delete-btn" onclick="deleteOrder(<?php echo e($order->id); ?>)">🗑️ Hapus</button>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 30px; color: var(--theme-muted);">
                            📭 Tidak ada pesanan
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination (only shown when using a paginator)
             the controller now returns a full collection, so make sure
             we don't try to call paginator methods on it -->
        <?php if($orders instanceof \Illuminate\Pagination\LengthAwarePaginator): ?>
            <div class="pagination">
                <?php if($orders->onFirstPage()): ?>
                    <span>← Sebelumnya</span>
                <?php else: ?>
                    <a href="<?php echo e($orders->previousPageUrl()); ?>">← Sebelumnya</a>
                <?php endif; ?>

                <?php $__currentLoopData = $orders->getUrlRange(1, $orders->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($page == $orders->currentPage()): ?>
                        <span class="active"><?php echo e($page); ?></span>
                    <?php else: ?>
                        <a href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php if($orders->hasMorePages()): ?>
                    <a href="<?php echo e($orders->nextPageUrl()); ?>">Selanjutnya →</a>
                <?php else: ?>
                    <span>Selanjutnya →</span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Initialize with existing orders from initial page load
        let lastOrderIds = new Set();
        let lastStatuses = {};
        let autoRefreshInterval = null;
        
        // Track initial orders that are loaded on page render
        function initializeInitialOrders() {
            const rows = document.querySelectorAll('table tbody tr[data-order-id]');
            rows.forEach(row => {
                const orderId = row.getAttribute('data-order-id');
                const statusSelect = row.querySelector('.status-select');
                if (orderId && statusSelect) {
                    lastOrderIds.add(parseInt(orderId));
                    lastStatuses[orderId] = statusSelect.value;
                }
            });
            console.log('✅ Initial orders loaded:', lastOrderIds.size);
        }

        function updateStatus(orderId, newStatus) {
            fetch('<?php echo e(route("admin.updateStatus", ":id")); ?>'.replace(':id', orderId), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({
                    status: newStatus
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Update visual feedback
                    const select = event.target;
                    select.className = 'status-select status-' + newStatus;
                    
                    // Show temporary success message
                    const message = document.createElement('div');
                    message.style.cssText = 'position: fixed; top: 60px; right: 20px; background: #dcfce7; color: #166534; padding: 15px 20px; border-radius: 6px; box-shadow: 0 3px 10px rgba(0,0,0,0.1); z-index: 1000; animation: slideIn 0.3s ease;';
                    message.textContent = '✅ Status pesanan diperbarui';
                    document.body.appendChild(message);
                    
                    setTimeout(() => message.remove(), 3000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal mengubah status pesanan');
            });
        }

        function deleteOrder(orderId) {
            if (confirm('⚠️ Apakah Anda yakin ingin menghapus pesanan ini?')) {
                fetch('<?php echo e(route("admin.deleteOrder", ":id")); ?>'.replace(':id', orderId), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Remove row with animation
                        const row = document.querySelector(`tr[data-order-id="${orderId}"]`);
                        row.style.animation = 'fadeOut 0.3s ease';
                        setTimeout(() => row.remove(), 300);

                        // Show success message
                        const message = document.createElement('div');
                        message.style.cssText = 'position: fixed; top: 60px; right: 20px; background: #dc2626; color: white; padding: 15px 20px; border-radius: 6px; box-shadow: 0 3px 10px rgba(0,0,0,0.1); z-index: 1000; animation: slideIn 0.3s ease;';
                        message.textContent = '🗑️ Pesanan dihapus';
                        document.body.appendChild(message);
                        
                        setTimeout(() => message.remove(), 3000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal menghapus pesanan');
                });
            }
        }

        let refreshCount = 0;
        let retryCount = 0;
        let maxRetries = 3;
        
        async function fetchDashboardData() {
            try {
                console.debug('fetchDashboardData() called');
                const response = await fetch('<?php echo e(route("admin.dashboardData")); ?>', {
                    credentials: 'same-origin',
                    headers: { 'Accept': 'application/json' }
                });
                const data = await response.json();

                if (response.ok) {
                    updateStatsCards(data.stats);
                    updateOrdersTable(data.orders);
                    retryCount = 0; // Reset retry count on success
                } else {
                    console.warn('dashboard data response not ok', data);
                    if (response.status === 401) {
                        // Redirect to login if unauthorized
                        window.location.href = '<?php echo e(route("admin.login")); ?>';
                    }
                }
            } catch (error) {
                console.error('Error fetching dashboard data:', error);
                retryCount++;
                if (retryCount <= maxRetries) {
                    // Exponential backoff: wait longer as retries increase
                    const waitTime = Math.pow(2, retryCount) * 500;
                    console.log(`Retrying in ${waitTime}ms... (${retryCount}/${maxRetries})`);
                }
            } finally {
                // bump counter regardless
                refreshCount++;
                const el = document.getElementById('refreshCounter');
                if (el) el.textContent = 'Updates: ' + refreshCount;
            }
        }

        function updateStatsCards(stats) {
            const statCards = document.querySelectorAll('.stat-card');
            const statLabels = ['pending', 'preparing', 'ready', 'completed'];
            
            statCards.forEach((card, index) => {
                const label = statLabels[index];
                const statValue = card.querySelector('.stat-value');
                const newValue = stats[label];
                
                if (statValue.textContent !== newValue.toString()) {
                    statValue.textContent = newValue;
                    card.style.animation = 'none';
                    setTimeout(() => {
                        card.style.animation = 'highlightPulse 0.6s ease';
                    }, 10);
                }
            });
        }

        function updateOrdersTable(orders) {
            const tbody = document.querySelector('table tbody');
            const statusClassMap = {
                'pending': 'status-pending',
                'preparing': 'status-preparing',
                'ready': 'status-ready',
                'completed': 'status-completed',
                'cancelled': 'status-cancelled'
            };

            // Mark current order IDs
            const currentOrderIds = new Set(orders.map(o => o.id));
            
            // Check if this is initial load (table only has "no orders" message)
            const isInitialLoad = tbody.querySelector('tr td[colspan="7"]') !== null;
            
            if (isInitialLoad && orders.length > 0) {
                // Clear the "no orders" message and add all orders
                tbody.innerHTML = '';
                orders.forEach(order => {
                    const newRow = document.createElement('tr');
                    newRow.setAttribute('data-order-id', order.id);
                    newRow.classList.add('highlight-row');
                    
                    newRow.innerHTML = `
                        <td class="order-number">${order.order_number}</td>
                        <td>
                            <div class="customer-info">
                                <span class="customer-name">${order.customer_name}</span>
                                ${order.customer_phone ? `<span class="customer-phone">${order.customer_phone}</span>` : ''}
                            </div>
                        </td>
                        <td>
                            <span class="items-count">${order.items_count} item</span>
                        </td>
                        <td class="price">Rp ${order.total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}</td>
                        <td>
                            <select 
                                class="status-select ${statusClassMap[order.status] || 'status-pending'}" 
                                onchange="updateStatus(${order.id}, this.value)"
                            >
                                <option value="pending" ${order.status === 'pending' ? 'selected' : ''}>⏳ Menunggu</option>
                                <option value="preparing" ${order.status === 'preparing' ? 'selected' : ''}>👨‍🍳 Diproses</option>
                                <option value="ready" ${order.status === 'ready' ? 'selected' : ''}>✓ Siap</option>
                                <option value="completed" ${order.status === 'completed' ? 'selected' : ''}>✓ Selesai</option>
                                <option value="cancelled" ${order.status === 'cancelled' ? 'selected' : ''}>❌ Batal</option>
                            </select>
                        </td>
                        <td class="timestamp">${order.created_at}</td>
                        <td>
                            <button class="delete-btn" onclick="deleteOrder(${order.id})">🗑️ Hapus</button>
                        </td>
                    `;
                    
                    tbody.appendChild(newRow);
                    setTimeout(() => newRow.classList.remove('highlight-row'), 600);
                    lastStatuses[order.id] = order.status;
                });
                return;
            }
            
            // Iterate orders and update/add rows (for subsequent updates)
            orders.forEach(order => {
                const row = document.querySelector(`tr[data-order-id="${order.id}"]`);
                
                if (row) {
                    // Update existing row
                    const statusSelect = row.querySelector('.status-select');
                    const newStatusClass = `status-select ${statusClassMap[order.status] || 'status-pending'}`;
                    
                    if (statusSelect.value !== order.status) {
                        // detect transition to "ready" or "completed" so we can
                        // notify the admin that payment has been received or the
                        // order is finished
                        if (order.status === 'ready' || order.status === 'completed') {
                            showPaymentNotification(order);
                        }
                        statusSelect.value = order.status;
                        statusSelect.className = newStatusClass;
                        row.classList.add('highlight-row');
                        setTimeout(() => row.classList.remove('highlight-row'), 600);
                    }
                } else {
                    // New order - add it to the top
                    const newRow = document.createElement('tr');
                    newRow.setAttribute('data-order-id', order.id);
                    newRow.classList.add('highlight-row');
                    
                    newRow.innerHTML = `
                        <td class="order-number">${order.order_number}</td>
                        <td>
                            <div class="customer-info">
                                <span class="customer-name">${order.customer_name}</span>
                                ${order.customer_phone ? `<span class="customer-phone">${order.customer_phone}</span>` : ''}
                            </div>
                        </td>
                        <td>
                            <span class="items-count">${order.items_count} item</span>
                        </td>
                        <td class="price">Rp ${order.total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}</td>
                        <td>
                            <select 
                                class="status-select ${statusClassMap[order.status] || 'status-pending'}" 
                                onchange="updateStatus(${order.id}, this.value)"
                            >
                                <option value="pending" ${order.status === 'pending' ? 'selected' : ''}>⏳ Menunggu</option>
                                <option value="preparing" ${order.status === 'preparing' ? 'selected' : ''}>👨‍🍳 Diproses</option>
                                <option value="ready" ${order.status === 'ready' ? 'selected' : ''}>✓ Siap</option>
                                <option value="completed" ${order.status === 'completed' ? 'selected' : ''}>✓ Selesai</option>
                                <option value="cancelled" ${order.status === 'cancelled' ? 'selected' : ''}>❌ Batal</option>
                            </select>
                        </td>
                        <td class="timestamp">${order.created_at}</td>
                        <td>
                            <button class="delete-btn" onclick="deleteOrder(${order.id})">🗑️ Hapus</button>
                        </td>
                    `;
                    
                    tbody.insertBefore(newRow, tbody.firstChild);
                    setTimeout(() => newRow.classList.remove('highlight-row'), 600);

                    // Show notification for new order and record its status
                    showNewOrderNotification(order);
                }

                // always update the status cache for the order we just processed
                lastStatuses[order.id] = order.status;
            });

            lastOrderIds = currentOrderIds;
        }

        function showNewOrderNotification(order) {
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                left: 50%;
                transform: translateX(-50%);
                background: linear-gradient(135deg, var(--theme-main) 0%, var(--theme-accent) 100%);
                color: white;
                padding: 16px 24px;
                border-radius: 8px;
                box-shadow: 0 12px 30px rgba(15, 118, 110, 0.28);
                z-index: 1001;
                animation: slideIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
                font-weight: 500;
                font-size: 0.95em;
            `;
            notification.innerHTML = `
                <strong style="font-size: 1.1em;">🔔 Pesanan Baru!</strong><br/>
                ${order.order_number} - Rp ${order.total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}
            `;
            document.body.appendChild(notification);
            
            // Try to play notification sound
            try {
                playSuccessSound();
            } catch (e) {
                console.log('Could not play sound:', e);
            }
            
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.4s ease';
                setTimeout(() => notification.remove(), 400);
            }, 5000);
        }

        // Create audio notification (using Web Audio API)
        function playSuccessSound() {
            // Create a beep sound using Web Audio API
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();
            
            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);
            
            oscillator.frequency.value = 800; // Frequency
            oscillator.type = 'sine';
            
            gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.5);
            
            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + 0.5);
        }

        // Confetti effect
        function createConfetti() {
            const canvas = document.getElementById('confetti-canvas');
            if (!canvas) return;
            
            const ctx = canvas.getContext('2d');
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            
            const confetti = [];
            const confettiCount = 50;
            
            for (let i = 0; i < confettiCount; i++) {
                confetti.push({
                    x: Math.random() * canvas.width,
                    y: -10,
                    vx: (Math.random() - 0.5) * 8,
                    vy: Math.random() * 5 + 5,
                    size: Math.random() * 4 + 2,
                    color: ['#0f766e', '#115e59', '#f97316', '#fdba74', '#ccfbf1', '#17202a'][Math.floor(Math.random() * 6)],
                    rotation: Math.random() * Math.PI * 2,
                    rotSpeed: (Math.random() - 0.5) * 0.2
                });
            }
            
            function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                
                let activeConfetti = false;
                
                confetti.forEach(particle => {
                    if (particle.y < canvas.height) {
                        particle.x += particle.vx;
                        particle.y += particle.vy;
                        particle.vy += 0.2; // gravity
                        particle.rotation += particle.rotSpeed;
                        
                        ctx.save();
                        ctx.translate(particle.x, particle.y);
                        ctx.rotate(particle.rotation);
                        ctx.fillStyle = particle.color;
                        ctx.fillRect(-particle.size / 2, -particle.size / 2, particle.size, particle.size);
                        ctx.restore();
                        
                        activeConfetti = true;
                    }
                });
                
                if (activeConfetti) {
                    requestAnimationFrame(animate);
                }
            }
            
            animate();
        }

        // display a impressive popup when an order is paid/ready state
        function showPaymentNotification(order) {
            // Play sound
            try {
                playSuccessSound();
            } catch (e) {
                console.log('Audio context error:', e);
            }
            
            // Create overlay
            const overlay = document.createElement('div');
            overlay.className = 'modal-overlay';
            
            // Create popup
            const popup = document.createElement('div');
            popup.className = 'payment-popup';
            popup.innerHTML = `
                <div class="confetti-icon">🎉</div>
                <h2>Pembayaran Diterima!</h2>
                <p><strong>${order.order_number}</strong></p>
                <div class="order-info">
                    <p>Nama: ${order.customer_name}</p>
                    <p>Total: Rp ${order.total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}</p>
                </div>
            `;
            
            document.body.appendChild(overlay);
            document.body.appendChild(popup);
            
            // Play confetti animation
            createConfetti();
            
            // Close after 4 seconds with animation
            setTimeout(() => {
                popup.style.animation = 'popupExit 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards';
                overlay.style.animation = 'fadeOut 0.5s ease forwards';
                
                setTimeout(() => {
                    popup.remove();
                    overlay.remove();
                }, 500);
            }, 4000);
        }

        // Initialize and start auto-refresh
        function startAutoRefresh() {
            // First, track all initial orders that are already rendered on page
            initializeInitialOrders();
            
            // Then fetch data to sync with latest from server
            fetchDashboardData();
            
            // Then refresh every 2 seconds (balanced between responsiveness and server load)
            autoRefreshInterval = setInterval(() => {
                if (retryCount <= maxRetries) {
                    fetchDashboardData();
                } else {
                    console.error('Max retries reached. Stopping auto-refresh.');
                    clearInterval(autoRefreshInterval);
                    
                    // Show error message
                    const errorMsg = document.createElement('div');
                    errorMsg.style.cssText = 'position: fixed; top: 60px; right: 20px; background: #dc2626; color: white; padding: 15px 20px; border-radius: 6px; box-shadow: 0 3px 10px rgba(0,0,0,0.1); z-index: 1000;';
                    errorMsg.textContent = '⚠️ Koneksi terputus. Silahkan refresh halaman.';
                    document.body.appendChild(errorMsg);
                }
            }, 2000); // Refresh every 2 seconds
        }

        // Start on page load
        window.addEventListener('load', startAutoRefresh);

        // Cleanup on page unload
        window.addEventListener('beforeunload', () => {
            if (autoRefreshInterval) {
                clearInterval(autoRefreshInterval);
            }
        });
    </script>

    <!-- Pusher & Echo untuk real-time updates (optional - polling sudah handle updates) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/7.0.3/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/npm/laravel-echo/dist/echo.iife.js"></script>
    <script>
        // Try to setup Echo for real-time updates (fallback to polling if not configured)
        try {
            if ('<?php echo e(env('PUSHER_APP_KEY')); ?>' && '<?php echo e(env('PUSHER_APP_KEY')); ?>' !== '') {
                Pusher.logToConsole = false;
                window.Echo = new Echo({
                    broadcaster: 'pusher',
                    key: '<?php echo e(env('PUSHER_APP_KEY')); ?>',
                    cluster: '<?php echo e(env('PUSHER_APP_CLUSTER')); ?>',
                    forceTLS: true,
                    wsHost: window.location.hostname,
                    wsPort: <?php echo e(env('PUSHER_APP_PORT', 6001)); ?>,
                    wssPort: <?php echo e(env('PUSHER_APP_PORT', 6001)); ?>,
                    disableStats: true,
                });

                // Listen for order events
                Echo.channel('orders')
                    .listen('OrderCreated', e => {
                        console.debug('received OrderCreated via Echo', e);
                        updateStatsCards(e.stats);
                        updateOrdersTable([e.order]);
                    })
                    .listen('OrderUpdated', e => {
                        console.debug('received OrderUpdated via Echo', e);
                        updateStatsCards(e.stats);
                        updateOrdersTable([e.order]);
                    });
                
                console.log('✅ Pusher Echo established - real-time updates enabled');
            } else {
                console.log('⚠️ Pusher not configured - using polling only');
            }
        } catch (error) {
            console.warn('⚠️ Could not setup Pusher/Echo:', error);
            console.log('Falling back to polling mechanism');
        }
    </script>

    <style>
        @keyframes slideIn {
            from { transform: translateX(-50%) translateY(-20px); opacity: 0; }
            to { transform: translateX(-50%) translateY(0); opacity: 1; }
        }

        @keyframes slideOut {
            from { transform: translateX(-50%) translateY(0); opacity: 1; }
            to { transform: translateX(-50%) translateY(-20px); opacity: 0; }
        }

        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
    </style>
</body>
</html>
<?php /**PATH C:\laragon\www\c7\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>