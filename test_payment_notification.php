<?php
/**
 * Testing Script for Real-Time Payment Notifications
 * 
 * Cara pakai:
 * php test_payment_notification.php
 * 
 * Script ini akan:
 * 1. Buat order baru dengan status "pending"
 * 2. Tunggu 3 detik
 * 3. Update status ke "ready" (simulasi pembayaran diterima)
 * 4. Admin dashboard akan otomatis menampilkan popup notification
 */

require __DIR__ . '/vendor/autoload.php';

use App\Models\Order;
use App\Models\MenuItem;
use App\Models\OrderItem;

// Bootstrap the application
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "🧪 Testing Real-Time Payment Notification System\n";
echo str_repeat("=", 50) . "\n\n";

try {
    // Step 1: Get available menu items
    echo "📋 Step 1: Mengambil menu items...\n";
    $menuItems = MenuItem::limit(2)->get();
    
    if ($menuItems->isEmpty()) {
        echo "❌ Tidak ada menu items! Jalankan seeder terlebih dahulu:\n";
        echo "   php artisan db:seed\n";
        exit(1);
    }
    
    echo "✅ Ditemukan " . $menuItems->count() . " menu items\n\n";
    
    // Step 2: Create a test order
    echo "📝 Step 2: Membuat pesanan test...\n";
    $order = Order::create([
        'order_number' => Order::generateOrderNumber(),
        'customer_name' => 'Tester Admin ' . date('H:i:s'),
        'customer_phone' => '0812345678',
        'status' => 'pending',
        'total_price' => 0,
        'notes' => 'Test payment notification',
        'ordered_at' => now(),
    ]);
    
    // Add items to order
    $totalPrice = 0;
    foreach ($menuItems as $menuItem) {
        OrderItem::create([
            'order_id' => $order->id,
            'menu_item_id' => $menuItem->id,
            'quantity' => 1,
            'price' => $menuItem->price,
        ]);
        $totalPrice += $menuItem->price;
    }
    
    $order->update(['total_price' => $totalPrice]);
    
    echo "✅ Pesanan dibuat!\n";
    echo "   Order ID: {$order->id}\n";
    echo "   Order Number: {$order->order_number}\n";
    echo "   Customer: {$order->customer_name}\n";
    echo "   Total: Rp " . number_format($totalPrice, 0, ',', '.') . "\n";
    echo "   Status: {$order->status}\n\n";
    
    // Step 3: Wait and simulate payment
    echo "⏳ Step 3: Menunggu 3 detik sebelum simulasi pembayaran...\n";
    echo "   (Buka admin dashboard untuk melihat order baru muncul)\n";
    sleep(3);
    
    // Step 4: Simulate payment received
    echo "\n💳 Step 4: Simulasi pembayaran diterima...\n";
    $order->update([
        'status' => 'ready',
        'payment_method' => 'cash',
        'completed_at' => now(),
    ]);
    
    echo "✅ Status order diubah ke 'ready'!\n";
    echo "   Admin akan melihat popup notification dengan:\n";
    echo "   - 🎉 Celebration emoji\n";
    echo "   - Gradient popup hijau di tengah layar\n";
    echo "   - Confetti animation\n";
    echo "   - Sound notification\n\n";
    
    // Step 5: Display summary
    echo str_repeat("=", 50) . "\n";
    echo "✅ Test selesai!\n\n";
    echo "📊 Order Details:\n";
    echo "   ID: {$order->id}\n";
    echo "   Order Number: {$order->order_number}\n";
    echo "   Status: {$order->status}\n";
    echo "   Customer: {$order->customer_name}\n";
    echo "   Items: {$order->items->count()}\n";
    echo "   Total: Rp " . number_format($order->total_price, 0, ',', '.') . "\n\n";
    
    echo "💡 Tips:\n";
    echo "   1. Buka admin dashboard jika belum\n";
    echo "   2. Lihat order baru muncul dengan highlight animation\n";
    echo "   3. Tunggu popup pembayaran sukses muncul otomatis\n";
    echo "   4. Perhatikan confetti animation dan sound notification\n\n";
    
    echo "🔄 Untuk test lagi, jalankan script ini kembali!\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "\nStack trace:\n";
    echo $e->getTraceAsString() . "\n";
    exit(1);
}
