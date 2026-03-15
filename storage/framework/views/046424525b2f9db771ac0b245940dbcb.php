<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan</title>
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
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .header-title {
            font-size: 2.2em;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }

        .header-subtitle {
            color: #666;
            font-size: 0.95em;
        }

        .filter-section {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 8px 16px;
            border: 2px solid #e0e0e0;
            background: white;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            font-size: 0.9em;
            color: #666;
        }

        .filter-btn:hover,
        .filter-btn.active {
            border-color: var(--theme-main);
            background: var(--theme-main);
            color: white;
        }

        .orders-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .order-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            border-left: 4px solid var(--theme-main);
        }

        .order-card:hover {
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .order-number {
            font-weight: 700;
            font-size: 1.1em;
            color: #333;
            font-family: 'Courier New', monospace;
        }

        .order-date {
            font-size: 0.85em;
            color: #999;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 700;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-preparing {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-ready {
            background: #d4edda;
            color: #155724;
        }

        .status-completed {
            background: #28a745;
            color: white;
        }

        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        .order-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px dashed #e0e0e0;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
        }

        .detail-label {
            font-size: 0.85em;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .detail-value {
            font-weight: 600;
            color: #333;
            font-size: 0.95em;
        }

        .order-items {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 15px;
        }

        .item-summary {
            font-size: 0.9em;
            color: #666;
            display: flex;
            justify-content: space-between;
        }

        .item-name {
            color: #333;
            font-weight: 500;
        }

        .order-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order-total {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .total-label {
            font-size: 0.85em;
            color: #999;
        }

        .total-amount {
            font-size: 1.3em;
            font-weight: 700;
            color: var(--theme-main);
        }

        .action-button {
            padding: 8px 16px;
            background: var(--theme-main);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            font-size: 0.9em;
            text-decoration: none;
            text-align: center;
        }

        .action-button:hover {
            background: #005bb5;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: white;
        }

        .empty-icon {
            font-size: 3.5em;
            margin-bottom: 20px;
        }

        .empty-title {
            font-size: 1.3em;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .empty-message {
            margin-bottom: 25px;
            opacity: 0.9;
        }

        .back-button {
            display: inline-block;
            padding: 12px 25px;
            background: white;
            color: #667eea;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 700;
            text-decoration: none;
        }

        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 30px;
        }

        .pagination a,
        .pagination span {
            padding: 8px 12px;
            border-radius: 6px;
            background: white;
            color: #667eea;
            text-decoration: none;
            border: 2px solid white;
            transition: all 0.3s ease;
        }

        .pagination a:hover {
            background: #667eea;
            color: white;
        }

        .pagination .active {
            background: #667eea;
            color: white;
            font-weight: 700;
        }

        @media (max-width: 600px) {
            .header {
                padding: 20px;
            }

            .header-title {
                font-size: 1.6em;
            }

            .filter-section {
                flex-direction: column;
            }

            .filter-btn {
                width: 100%;
            }

            .order-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .order-details {
                grid-template-columns: 1fr;
            }

            .order-footer {
                flex-direction: column;
                gap: 12px;
                align-items: flex-start;
            }

            .order-total {
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-title">📜 Riwayat Pesanan</div>
            <div class="header-subtitle">Lihat semua pesanan yang telah Anda buat</div>
            
            <div class="filter-section">
                <button class="filter-btn active" onclick="filterByStatus(null)">Semua</button>
                <button class="filter-btn" onclick="filterByStatus('pending')">⏳ Menunggu</button>
                <button class="filter-btn" onclick="filterByStatus('preparing')">👨‍🍳 Diproses</button>
                <button class="filter-btn" onclick="filterByStatus('ready')">✓ Siap</button>
                <button class="filter-btn" onclick="filterByStatus('completed')">✓ Selesai</button>
            </div>
        </div>

        <!-- Orders List or Empty State -->
        <?php if($orders->count() > 0): ?>
            <div class="orders-container">
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="order-card" data-status="<?php echo e($order->status); ?>" onclick="viewOrder(<?php echo e($order->id); ?>)">
                    <div class="order-header">
                        <div style="flex: 1;">
                            <div class="order-number">#<?php echo e($order->order_number); ?></div>
                            <div class="order-date"><?php echo e($order->ordered_at ? $order->ordered_at->format('d M Y · H:i') : $order->created_at->format('d M Y · H:i')); ?></div>
                        </div>
                        <span class="status-badge status-<?php echo e($order->status); ?>">
                            <?php if($order->status == 'pending'): ?> ⏳ Menunggu
                            <?php elseif($order->status == 'preparing'): ?> 👨‍🍳 Diproses
                            <?php elseif($order->status == 'ready'): ?> ✓ Siap Diambil
                            <?php elseif($order->status == 'completed'): ?> ✓ Selesai
                            <?php else: ?> Dibatalkan <?php endif; ?>
                        </span>
                    </div>

                    <div class="order-details">
                        <div class="detail-item">
                            <div class="detail-label">Pemesan</div>
                            <div class="detail-value"><?php echo e($order->customer_name); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Telepon</div>
                            <div class="detail-value"><?php echo e($order->customer_phone ?? '-'); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Jumlah Item</div>
                            <div class="detail-value"><?php echo e($order->items->count()); ?> item</div>
                        </div>
                    </div>

                    <div class="order-items">
                        <?php $__currentLoopData = $order->items->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="item-summary">
                            <span class="item-name"><?php echo e($item->menuItem->name ?? 'Item'); ?></span>
                            <span>x<?php echo e($item->quantity); ?></span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if($order->items->count() > 2): ?>
                        <div class="item-summary" style="color: var(--theme-main); font-style: italic;">
                            +<?php echo e($order->items->count() - 2); ?> item lainnya
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="order-footer">
                        <div class="order-total">
                            <div class="total-label">Total Harga</div>
                            <div class="total-amount">Rp <?php echo e(number_format($order->total_price, 0, ',', '.')); ?></div>
                        </div>
                        <a href="<?php echo e(route('order.track', $order->order_number)); ?>" class="action-button">Lihat Detil →</a>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Pagination -->
            <?php if($orders->hasPages()): ?>
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

        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <div class="empty-title">Belum Ada Pesanan</div>
                <div class="empty-message">Mulai pesan dari menu untuk melihat riwayat pesanan Anda</div>
                <a href="<?php echo e(route('menu.index')); ?>" class="back-button">← Kembali ke Menu</a>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function filterByStatus(status) {
            // update button styling
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');

            // show/hide orders based on status
            document.querySelectorAll('.order-card').forEach(card => {
                if (status === null || card.dataset.status === status) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function viewOrder(orderId) {
            // Navigate to order details/tracking
            // This is handled by clicking the "Lihat Detil" button
        }

        // fallback polling: reload every 10 seconds so the list stays current
        setInterval(() => {
            console.debug('history fallback reload');
            window.location.reload();
        }, 10000);
    </script>

    <!-- optionally include Pusher/Echo for live refresh -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/7.0.3/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/npm/laravel-echo/dist/echo.iife.js"></script>
    <script>
        Pusher.logToConsole = true;
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

        Echo.channel('orders')
            .listen('OrderCreated', e => {
                console.debug('history - order created', e);
                // simple approach: reload so the list stays accurate
                window.location.reload();
            })
            .listen('OrderUpdated', e => {
                console.debug('history - order updated', e);
                window.location.reload();
            });
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\c7\resources\views/order/history.blade.php ENDPATH**/ ?>