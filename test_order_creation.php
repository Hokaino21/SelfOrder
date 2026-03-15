<?php
require 'vendor/autoload.php';
require 'bootstrap/app.php';

use App\Models\Order;
use App\Models\MenuItem;
use App\Models\OrderItem;

echo "\n🧪 SIMULATING ORDER FORM SUBMISSION\n";
echo str_repeat('=', 100) . "\n";

// Check if menu items exist
$menuItems = MenuItem::take(2)->get();
if ($menuItems->isEmpty()) {
    echo "❌ Tidak ada menu items! Silakan jalankan: php artisan db:seed MenuSeeder\n";
    exit(1);
}

echo "\n📋 Menu Items Available:\n";
foreach ($menuItems as $item) {
    echo "   - ID:{$item->id} | {$item->name} | Rp " . number_format($item->price, 0, ',', '.') . "\n";
}

// Simulate form submission
echo "\n\n🎯 SIMULASI FORM SUBMISSION:\n";
echo "   Nama Pemesan: Test User\n";
echo "   Telepon: +6281234567890\n";

$validated = [
    'customer_name' => 'Test User',
    'customer_phone' => '+6281234567890',
    'notes' => 'Test order',
    'cart' => []
];

// Build cart from menu items
foreach ($menuItems as $item) {
    $validated['cart'][] = [
        'menu_item_id' => $item->id,
        'quantity' => 1
    ];
}

echo "   Items: " . count($validated['cart']) . "\n\n";

try {
    // Create order (same as OrderController::store)
    echo "📝 Creating Order...\n";
    
    $order = Order::create([
        'order_number' => Order::generateOrderNumber(),
        'customer_name' => $validated['customer_name'],
        'customer_phone' => $validated['customer_phone'] ?? null,
        'notes' => $validated['notes'] ?? null,
        'status' => 'pending',
        'total_price' => 0,
        'ordered_at' => now(),
    ]);
    
    echo "   ✅ Order created: #{$order->id} | {$order->order_number}\n";
    
    $totalPrice = 0;
    foreach ($validated['cart'] as $item) {
        $menuItem = MenuItem::find($item['menu_item_id']);
        $itemTotal = $menuItem->price * $item['quantity'];
        $totalPrice += $itemTotal;

        echo "   Adding item: {$menuItem->name} x{$item['quantity']}...\n";
        
        OrderItem::create([
            'order_id' => $order->id,
            'menu_item_id' => $item['menu_item_id'],
            'quantity' => $item['quantity'],
            'price' => $menuItem->price,
        ]);
        
        echo "      ✅ Saved\n";
    }

    $order->update(['total_price' => $totalPrice]);
    echo "\n   ✅ Total price updated: Rp " . number_format($totalPrice, 0, ',', '.') . "\n";

} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "Stack: " . $e->getTraceAsString() . "\n";
    exit(1);
}

// Verify in database
echo "\n\n✅ VERIFYING IN DATABASE:\n";
$savedOrder = Order::with('items.menuItem')->find($order->id);

if ($savedOrder) {
    echo "✅ Order ditemukan di database\n";
    echo "   Order Number: {$savedOrder->order_number}\n";
    echo "   Customer: {$savedOrder->customer_name}\n";
    echo "   Phone: {$savedOrder->customer_phone}\n";
    echo "   Total: Rp " . number_format($savedOrder->total_price, 0, ',', '.') . "\n";
    echo "   Status: {$savedOrder->status}\n";
    echo "   Items: " . $savedOrder->items->count() . "\n";
} else {
    echo "❌ Order NOT FOUND in database!\n";
    exit(1);
}

// Check API response
echo "\n\n📡 API RESPONSE (what dashboard sees):\n";
$apiData = [
    'id' => $savedOrder->id,
    'order_number' => $savedOrder->order_number,
    'customer_name' => $savedOrder->customer_name,
    'customer_phone' => $savedOrder->customer_phone,
    'status' => $savedOrder->status,
    'total_price' => $savedOrder->total_price,
    'items_count' => $savedOrder->items->count(),
    'created_at' => $savedOrder->created_at->format('d/m/Y H:i'),
];

echo json_encode($apiData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";

// Check all orders
echo "\n\n📊 ALL ORDERS IN DATABASE:\n";
$allOrders = Order::with('items')->orderBy('created_at', 'desc')->get();
echo "Total: {$allOrders->count()} orders\n";

foreach ($allOrders as $o) {
    echo "  - {$o->order_number} | {$o->customer_name} | Rp " . number_format($o->total_price, 0, ',', '.') . " | {$o->items->count()} items\n";
}

echo "\n✅ SIMULATION COMPLETE - Order successfully created and saved!\n";
echo str_repeat('=', 100) . "\n";
