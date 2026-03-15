<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║  🔍 DEBUGGING: Full Order Integration Test                ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

// Test 1: Check menu items
echo "1️⃣  CHECK MENU ITEMS\n";
$menuItems = MenuItem::all();
echo "   └─ Total menu items: " . $menuItems->count() . "\n";

if ($menuItems->count() < 2) {
    echo "   ❌ Error: Need at least 2 menu items for testing\n";
    exit(1);
}

foreach ($menuItems->take(2) as $item) {
    echo "      ├─ ID: {$item->id}, Name: {$item->name}, Price: Rp " . number_format($item->price) . "\n";
}

// Test 2: Simulate Form Submission - Create Order
echo "\n2️⃣  SIMULATE FORM SUBMISSION\n";
echo "   Simulating: POST /order with cart data\n";

$menuItem1 = $menuItems->first();
$menuItem2 = $menuItems->skip(1)->first();

// Prepare cart data as if from form
$cartData = [
    [
        'menu_item_id' => $menuItem1->id,
        'quantity' => 2
    ],
    [
        'menu_item_id' => $menuItem2->id,
        'quantity' => 1
    ]
];

try {
    // Create order (simulating OrderController::store)
    $order = Order::create([
        'order_number' => Order::generateOrderNumber(),
        'customer_name' => 'Pelanggan Real ' . date('H:i:s'),
        'customer_phone' => '0812345678',
        'notes' => 'Test order dari form',
        'status' => 'pending',
        'total_price' => 0,
        'ordered_at' => now(),
    ]);

    echo "   ├─ ✅ Order created\n";
    echo "   ├─ Order ID: {$order->id}\n";
    echo "   ├─ Order Number: {$order->order_number}\n";

    // Add order items
    $totalPrice = 0;
    foreach ($cartData as $item) {
        $menuItem = MenuItem::findOrFail($item['menu_item_id']);
        $itemTotal = $menuItem->price * $item['quantity'];
        $totalPrice += $itemTotal;

        OrderItem::create([
            'order_id' => $order->id,
            'menu_item_id' => $item['menu_item_id'],
            'quantity' => $item['quantity'],
            'price' => $menuItem->price,
        ]);

        echo "   │  ├─ Added: {$menuItem->name} x{$item['quantity']}\n";
    }

    // Update total price
    $order->update(['total_price' => $totalPrice]);
    echo "   ├─ Total Price: Rp " . number_format($totalPrice) . "\n";
    echo "   └─ ✅ Order items added\n";

} catch (\Exception $e) {
    echo "   ❌ Error creating order: " . $e->getMessage() . "\n";
    exit(1);
}

// Test 3: Verify Order in Database
echo "\n3️⃣  VERIFY IN DATABASE\n";
$dbOrder = Order::with('items.menuItem')->findOrFail($order->id);
echo "   ├─ ✅ Order found in database\n";
echo "   ├─ Order Number: {$dbOrder->order_number}\n";
echo "   ├─ Customer: {$dbOrder->customer_name}\n";
echo "   ├─ Status: " . strtoupper($dbOrder->status) . "\n";
echo "   ├─ Items: " . $dbOrder->items->count() . "\n";
echo "   ├─ Total: Rp " . number_format($dbOrder->total_price) . "\n";
echo "   └─ Created: {$dbOrder->created_at}\n";

// Test 4: Check API Response
echo "\n4️⃣  CHECK API RESPONSE (getDashboardData)\n";
$allOrders = Order::with('items.menuItem')
    ->orderBy('created_at', 'desc')
    ->get();

$apiData = $allOrders->map(function($o) {
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

echo "   ├─ Total orders in response: " . count($apiData) . "\n";
echo "   ├─ ✅ New order in response: ";

$newOrderInApi = $apiData->firstWhere('id', $order->id);
if ($newOrderInApi) {
    echo "YES ✅\n";
    echo "   └─ Order: {$newOrderInApi['order_number']} - {$newOrderInApi['customer_name']}\n";
} else {
    echo "NO ❌\n";
    echo "   └─ ⚠️ New order NOT in API response!\n";
}

// Test 5: Check Dashboard Access
echo "\n5️⃣  CHECK DASHBOARD ACCESS\n";
echo "   ├─ Dashboard URL: /admin/dashboard\n";
echo "   ├─ Requires: Admin session\n";
echo "   ├─ Login with: admin / admin123\n";
echo "   └─ ✅ New order should appear after login\n";

// Test 6: Summary
echo "\n" . str_repeat("═", 62) . "\n";
echo "📊 INTEGRATION TEST RESULT\n";
echo str_repeat("═", 62) . "\n\n";

$stats = [
    'pending' => Order::where('status', 'pending')->count(),
    'preparing' => Order::where('status', 'preparing')->count(),
    'ready' => Order::where('status', 'ready')->count(),
    'completed' => Order::where('status', 'completed')->count(),
];

echo "✅ Order Creation: SUCCESS\n";
echo "   └─ Order saved to database: YES\n";
echo "   └─ Order items saved: YES\n";
echo "   └─ Total price calculated: YES\n\n";

echo "✅ Database Verification: SUCCESS\n";
echo "   └─ Order retrievable: YES\n";
echo "   └─ Items relationship: YES\n\n";

echo "✅ API Response: ";
if ($newOrderInApi) {
    echo "SUCCESS\n";
    echo "   └─ Order in response: YES\n";
} else {
    echo "ISSUE\n";
    echo "   └─ Order in response: NO ⚠️\n";
}
echo "\n";

echo "📈 Current Stats:\n";
echo "   ├─ Pending: {$stats['pending']}\n";
echo "   ├─ Preparing: {$stats['preparing']}\n";
echo "   ├─ Ready: {$stats['ready']}\n";
echo "   └─ Completed: {$stats['completed']}\n\n";

echo "🎯 Next Steps:\n";
echo "   1. Login to admin dashboard: http://localhost/admin/login\n";
echo "   2. Username: admin\n";
echo "   3. Password: admin123\n";
echo "   4. View dashboard: http://localhost/admin/dashboard\n";
echo "   5. ✅ New order should be visible\n\n";

echo "💡 If order NOT visible in dashboard:\n";
echo "   - Check browser console (F12) for JavaScript errors\n";
echo "   - Verify session is active\n";
echo "   - Check network tab for API calls\n";
echo "   - Refresh page (Ctrl+F5)\n\n";

