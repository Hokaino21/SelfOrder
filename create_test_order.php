<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;

$menu = MenuItem::first();
if (!$menu) {
    echo "no menu items, please run menu seeder\n";
    exit(1);
}

$order = Order::create([
    'order_number' => Order::generateOrderNumber(),
    'customer_name' => 'Tester',
    'customer_phone' => '+628123456789',
    'notes' => 'Test order',
    'status' => 'pending',
    'total_price' => $menu->price,
    'ordered_at' => now(),
]);

OrderItem::create([
    'order_id' => $order->id,
    'menu_item_id' => $menu->id,
    'quantity' => 1,
    'price' => $menu->price,
]);

echo "created order id {$order->id}\n";
