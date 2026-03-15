<?php
require 'vendor/autoload.php';
require 'bootstrap/app.php';

use App\Models\Order;
use App\Models\MenuItem;

echo "\n🔍 DETAILED ORDER VERIFICATION\n";
echo str_repeat('=', 100) . "\n";

// Get all orders
$orders = Order::with('items.menuItem')->orderBy('created_at', 'desc')->get();

if ($orders->isEmpty()) {
    echo "❌ Belum ada orders di database!\n";
    exit;
}

// Simulate what the API returns
echo "\n📡 API Response Format Check:\n";
foreach ($orders->take(3) as $order) {
    $apiResponse = [
        'id' => $order->id,
        'order_number' => $order->order_number,
        'customer_name' => $order->customer_name,
        'customer_phone' => $order->customer_phone,
        'status' => $order->status,
        'total_price' => $order->total_price,
        'items_count' => $order->items->count(),
        'created_at' => $order->created_at->format('d/m/Y H:i'),
    ];
    
    echo "\n✅ Order #{$order->id}\n";
    echo json_encode($apiResponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
    echo str_repeat('-', 100) . "\n";
}

// Check if all orders have what they need
echo "\n📋 Summary Check:\n";
foreach ($orders as $order) {
    $itemCount = $order->items->count();
    
    // Check required data
    $issues = [];
    if (!$order->customer_name) $issues[] = "customer_name kosong";
    if (!$order->order_number) $issues[] = "order_number kosong";
    if ($order->total_price === null || $order->total_price == 0) {
        $issues[] = "total_price kosong/0";
    }
    if ($itemCount == 0) $issues[] = "items kosong";
    
    if ($issues) {
        echo "❌ Order #{$order->id} ({$order->order_number}): " . implode(", ", $issues) . "\n";
    } else {
        echo "✅ Order #{$order->id} ({$order->order_number}): customer={$order->customer_name}, items={$itemCount}, total=Rp " . number_format($order->total_price, 0, ',', '.') . "\n";
    }
}

echo "\n";
