<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Order;

echo "=== DEBUGGING ORDER DATA ===\n\n";

echo "1. Total Orders: " . Order::count() . "\n";

echo "\n2. Recent Orders in Database:\n";
$orders = Order::latest()->limit(5)->get();
if ($orders->isEmpty()) {
    echo "   ⚠️  No orders found!\n";
} else {
    foreach ($orders as $order) {
        echo sprintf("   - ID: %d, Number: %s, Customer: %s, Status: %s, Created: %s\n", 
            $order->id, $order->order_number, $order->customer_name, $order->status, $order->created_at);
    }
}

echo "\n3. Orders by Status:\n";
$statusCounts = Order::selectRaw('status, count(*) as count')
    ->groupBy('status')
    ->get();

if ($statusCounts->isEmpty()) {
    echo "   ⚠️  No orders to analyze\n";
} else {
    foreach ($statusCounts as $status) {
        echo sprintf("   - %s: %d\n", $status->status, $status->count);
    }
}

echo "\n4. Database Connection Test:\n";
try {
    $testQuery = \DB::select('SELECT 1');
    echo "   ✅ Database connection OK\n";
} catch (\Exception $e) {
    echo "   ❌ Database connection FAILED: " . $e->getMessage() . "\n";
}

echo "\n5. Tables Check:\n";
$tables = \DB::select("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = DATABASE()");
$tableNames = array_map(function($t) { return $t->TABLE_NAME; }, $tables);
echo "   Tables found: " . count($tableNames) . "\n";
if (in_array('orders', $tableNames)) {
    echo "   ✅ orders table exists\n";
} else {
    echo "   ❌ orders table NOT found\n";
}

if (in_array('menu_items', $tableNames)) {
    echo "   ✅ menu_items table exists\n";
} else {
    echo "   ❌ menu_items table NOT found\n";
}

if (in_array('order_items', $tableNames)) {
    echo "   ✅ order_items table exists\n";
} else {
    echo "   ❌ order_items table NOT found\n";
}

echo "\n";
