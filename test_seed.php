<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Order, App\Models\OrderItem, App\Models\MenuItem;

echo "🌱 Creating test orders...\n\n";

// Create 3 test orders
for ($i = 0; $i < 3; $i++) {
    $order = Order::create([
        'order_number' => Order::generateOrderNumber(),
        'customer_name' => ['Budi Santoso', 'Siti Nurhayati', 'Rahmat Wijaya'][$i],
        'customer_phone' => ['0812-3456-7890', '0815-6789-0123', '0821-1234-5678'][$i],
        'status' => ['pending', 'preparing', 'ready'][$i],
        'total_price' => 0,
        'ordered_at' => now()->subMinutes(rand(1, 60)),
    ]);

    $menuItems = MenuItem::inRandomOrder()->take(rand(2, 4))->get();
    $totalPrice = 0;

    foreach ($menuItems as $item) {
        $qty = rand(1, 3);
        $itemTotal = $item->price * $qty;
        $totalPrice += $itemTotal;

        OrderItem::create([
            'order_id' => $order->id,
            'menu_item_id' => $item->id,
            'quantity' => $qty,
            'price' => $item->price,
        ]);
    }

    $order->update(['total_price' => $totalPrice]);

    $statusEmoji = ['⏳ Pending', '👨‍🍳 Preparing', '✓ Ready'][$i];
    echo "✅ Order $i created: {$order->order_number} - {$statusEmoji}\n";
}

echo "\n✅ Test data created successfully!\n";
echo "🔗 Admin: http://127.0.0.1:8000/admin/login\n";
echo "🔒 Credentials: admin / admin123\n";
