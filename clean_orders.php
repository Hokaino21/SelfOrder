<?php
require 'vendor/autoload.php';
require 'bootstrap/app.php';

use App\Models\Order;
use App\Models\OrderItem;

echo "\n🧹 CLEANING OLD DATA...\n";
echo str_repeat('=', 100) . "\n";

// Delete all orders and items
$deletedOrders = Order::count();
$deletedItems = OrderItem::count();

OrderItem::truncate();
Order::truncate();

echo "✅ Deleted {$deletedOrders} old orders\n";
echo "✅ Deleted {$deletedItems} old order items\n";

echo "\n📋 Database is now CLEAN\n";
echo "Ready for fresh test orders!\n";
echo "\nNext steps:\n";
echo "1. Go to http://localhost/menu\n";
echo "2. Select items\n";
echo "3. Fill form with correct data\n";
echo "4. Submit order\n";
echo "5. Login to http://localhost/admin/dashboard\n";
echo "6. Data should now be CORRECT\n";
echo str_repeat('=', 100) . "\n";
