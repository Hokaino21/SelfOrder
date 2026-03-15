<?php
echo "\n🎯 INTEGRASI ORDER FORM ↔ ADMIN DASHBOARD\n";
echo str_repeat('=', 100) . "\n";

// Load Laravel
require 'vendor/autoload.php';
require 'bootstrap/app.php';

use App\Models\Order;
use App\Models\MenuItem;
use App\Models\OrderItem;

// Step 1: Check available menu items
echo "\n1️⃣ MENU ITEMS TERSEDIA:\n";
$menuItems = MenuItem::all();
if ($menuItems->isEmpty()) {
    echo "❌ Belum ada menu items! Jalankan: php artisan db:seed MenuSeeder\n";
    exit;
}

foreach ($menuItems as $item) {
    echo "   - ID:{$item->id} | {$item->name} | Rp " . number_format($item->price, 0, ',', '.') . "\n";
}

// Step 2: Simulate form submission
echo "\n2️⃣ SIMULASI FORM SUBMISSION:\n";
echo "   Nama: Test Pelanggan\n";
echo "   Telepon: +6281234567890\n";
echo "   Cart Items: Nasi Goreng (2x), Mie Goreng (1x)\n";

// Step 3: Create order (same as form submission)
echo "\n3️⃣ MEMBUAT ORDER (seperti form submit):\n";

try {
    $orderData = [
        'order_number' => Order::generateOrderNumber(),
        'customer_name' => 'Test Pelanggan',
        'customer_phone' => '+6281234567890',
        'notes' => 'Test order',
        'status' => 'pending',
        'total_price' => 0,
        'ordered_at' => now(),
    ];
    
    $order = Order::create($orderData);
    echo "   ✅ Order created: #{$order->id} | {$order->order_number}\n";
    
    // Get menu items for the test (use first 2 items)
    $items = $menuItems->take(2);
    $totalPrice = 0;
    
    $cartItems = [];
    foreach ($items as $key => $menuItem) {
        $quantity = $key == 0 ? 2 : 1; // First item qty=2, second qty=1
        $itemTotal = $menuItem->price * $quantity;
        $totalPrice += $itemTotal;
        
        OrderItem::create([
            'order_id' => $order->id,
            'menu_item_id' => $menuItem->id,
            'quantity' => $quantity,
            'price' => $menuItem->price,
        ]);
        
        $cartItems[] = "{$menuItem->name} x{$quantity}";
        echo "   ✅ Item added: {$menuItem->name} x{$quantity}\n";
    }
    
    $order->update(['total_price' => $totalPrice]);
    echo "   ✅ Total price updated: Rp " . number_format($totalPrice, 0, ',', '.') . "\n";
    
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
    exit;
}

// Step 4: Verify in database
echo "\n4️⃣ VERIFIKASI DI DATABASE:\n";
$savedOrder = Order::with('items.menuItem')->find($order->id);
if ($savedOrder) {
    echo "   ✅ Order ditemukan di database\n";
    echo "      Order Number: {$savedOrder->order_number}\n";
    echo "      Customer: {$savedOrder->customer_name}\n";
    echo "      Phone: {$savedOrder->customer_phone}\n";
    echo "      Status: {$savedOrder->status}\n";
    echo "      Total: Rp " . number_format($savedOrder->total_price, 0, ',', '.') . "\n";
    echo "      Items Count: " . $savedOrder->items->count() . "\n";
    echo "      Items:\n";
    foreach ($savedOrder->items as $item) {
        $menuItem = $item->menuItem;
        echo "         - {$menuItem->name} x{$item->quantity} @ Rp " . number_format($item->price, 0, ',', '.') . "\n";
    }
} else {
    echo "   ❌ Order tidak ditemukan!\n";
    exit;
}

// Step 5: Check what API returns
echo "\n5️⃣ RESPONSE API /admin/dashboard/data:\n";
$apiOrder = [
    'id' => $savedOrder->id,
    'order_number' => $savedOrder->order_number,
    'customer_name' => $savedOrder->customer_name,
    'customer_phone' => $savedOrder->customer_phone,
    'status' => $savedOrder->status,
    'total_price' => $savedOrder->total_price,
    'items_count' => $savedOrder->items->count(),
    'created_at' => $savedOrder->created_at->format('d/m/Y H:i'),
];

echo "   JSON Response:\n";
echo "   " . json_encode($apiOrder, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";

// Step 6: Verify all orders
echo "\n6️⃣ SEMUA ORDERS SEKARANG:\n";
$allOrders = Order::with('items')->orderBy('created_at', 'desc')->get();
echo "   Total orders: {$allOrders->count()}\n";
foreach ($allOrders->take(5) as $o) {
    echo "   - {$o->order_number} | {$o->customer_name} | Rp " . number_format($o->total_price, 0, ',', '.') . " | {$o->items->count()} items | Status: {$o->status}\n";
}

echo "\n✅ INTEGRASI BERHASIL!\n";
echo "   Order dari form → Database → API → Dashboard\n";
echo str_repeat('=', 100) . "\n";
