<?php
require 'vendor/autoload.php';
require 'bootstrap/app.php';

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;

echo "📋 DAFTAR PESANAN DI DATABASE:\n";
echo str_repeat('=', 100) . "\n";

$orders = Order::orderBy('created_at', 'desc')->get();

if ($orders->isEmpty()) {
    echo "❌ Belum ada pesanan di database!\n";
    exit;
}

foreach ($orders as $order) {
    echo "\n📝 Order ID: {$order->id}\n";
    echo "   Nomor: {$order->order_number}\n";
    echo "   Pemesan: {$order->customer_name}\n";
    echo "   Telepon: {$order->customer_phone}\n";
    echo "   Status: {$order->status}\n";
    echo "   Items:\n";
    
    $items = OrderItem::where('order_id', $order->id)->get();
    if ($items->isEmpty()) {
        echo "      (Tidak ada item!)\n";
    } else {
        foreach ($items as $item) {
            $menuItem = MenuItem::find($item->menu_item_id);
            $itemName = $menuItem ? $menuItem->name : "Unknown (ID: {$item->menu_item_id})";
            echo "      - {$itemName}: {$item->quantity}x Rp " . number_format($item->price, 0, ',', '.') . "\n";
        }
    }
    
    echo "   Total: Rp " . number_format($order->total_price, 0, ',', '.') . "\n";
    echo "   Waktu: {$order->created_at}\n";
    echo str_repeat('-', 100) . "\n";
}

echo "\n📊 TOTAL PESANAN: " . $orders->count() . " orders\n";
echo "\n✅ Database check complete.\n";
