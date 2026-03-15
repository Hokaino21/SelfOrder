<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Order;
use App\Models\MenuItem;
use App\Models\OrderItem;

echo "=== FULL ORDER TRACE ===\n\n";

// Get a sample order with full data
$order = Order::with('items.menuItem')->latest()->first();

if (!$order) {
    echo "❌ No orders found\n";
    exit;
}

echo "Order Details:\n";
echo "  ID: " . $order->id . "\n";
echo "  Number: " . $order->order_number . "\n";
echo "  Customer: " . $order->customer_name . "\n";
echo "  Phone: " . ($order->customer_phone ?? 'N/A') . "\n";
echo "  Status: " . $order->status . "\n";
echo "  Total: Rp " . number_format($order->total_price) . "\n";
echo "  Created: " . $order->created_at . "\n";
echo "  Items Count: " . $order->items->count() . "\n";

echo "\nOrder Items:\n";
foreach ($order->items as $item) {
    $menuItem = $item->menuItem;
    echo sprintf("  - %s (ID: %d): Qty %d x Rp %s = Rp %s\n",
        $menuItem->name ?? 'Unknown',
        $item->menu_item_id,
        $item->quantity,
        number_format($item->price),
        number_format($item->price * $item->quantity)
    );
}

echo "\n=== TEST API RESPONSE ===\n";
echo "Testing getDashboardData() response structure:\n\n";

$orders = Order::with('items.menuItem')
    ->orderBy('created_at', 'desc')
    ->get();

echo "Total Orders: " . count($orders) . "\n\n";

$mapData = $orders->map(function($o) {
    return [
        'id' => $o->id,
        'order_number' => $o->order_number,
        'customer_name' => $o->customer_name,
        'customer_phone' => $o->customer_phone,
        'status' => $o->status,
        'total_price' => $o->total_price,
        'items_count' => $o->items->count(),
        'created_at' => $o->created_at->format('d/m/Y H:i'),
    ];
});

echo "Sample API response for first order:\n";
echo json_encode($mapData->first(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";

echo "\n";
