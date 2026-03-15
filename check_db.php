<?php
require 'vendor/autoload.php';
require 'bootstrap/app.php';

use App\Models\Order;

echo "\n🔍 DETAIL DATA DI DATABASE:\n";
echo str_repeat('=', 120) . "\n";

$orders = Order::with('items.menuItem')->orderBy('created_at', 'desc')->get();

if ($orders->isEmpty()) {
    echo "❌ Tidak ada orders!\n";
    exit;
}

foreach ($orders->take(5) as $order) {
    echo "\n📝 Order #{$order->id}\n";
    echo "   Order Number: {$order->order_number}\n";
    echo "   Customer Name: '{$order->customer_name}' (length: " . strlen($order->customer_name) . ")\n";
    echo "   Customer Phone: '{$order->customer_phone}'\n";
    echo "   Total Price: {$order->total_price}\n";
    echo "   Status: {$order->status}\n";
    echo "   Created At: {$order->created_at}\n";
    echo "   Items Count: " . $order->items->count() . "\n";
    echo "   Items:\n";
    foreach ($order->items as $item) {
        echo "      - {$item->menuItem->name} x{$item->quantity} @ Rp " . number_format($item->price, 0, ',', '.') . "\n";
    }
    echo str_repeat('-', 120) . "\n";
}

echo "\n";
