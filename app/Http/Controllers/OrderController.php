<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create()
    {
        return view('order.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string|max:500',
            'cart' => 'required|array|min:1',
            'cart.*.menu_item_id' => 'required|exists:menu_items,id',
            'cart.*.quantity' => 'required|integer|min:1',
        ]);

        $order = \App\Models\Order::create([
            'order_number' => \App\Models\Order::generateOrderNumber(),
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending',
            'total_price' => 0,
            'ordered_at' => now(),
        ]);

        $totalPrice = 0;
        foreach ($validated['cart'] as $item) {
            $menuItem = \App\Models\MenuItem::find($item['menu_item_id']);
            $itemTotal = $menuItem->price * $item['quantity'];
            $totalPrice += $itemTotal;

            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'menu_item_id' => $item['menu_item_id'],
                'quantity' => $item['quantity'],
                'price' => $menuItem->price,
            ]);
        }

        $order->update(['total_price' => $totalPrice]);

        return redirect()->route('order.receipt', $order->id)
            ->with('success', 'Pesanan berhasil dibuat!');
    }

    public function receipt($id)
    {
        $order = \App\Models\Order::with('items.menuItem')->findOrFail($id);
        return view('order.receipt', compact('order'));
    }

    public function track($orderNumber)
    {
        $order = \App\Models\Order::where('order_number', $orderNumber)->with('items.menuItem')->firstOrFail();
        return view('order.track', compact('order'));
    }

    public function status($id)
    {
        $order = \App\Models\Order::findOrFail($id);
        return response()->json([
            'status' => $order->status,
            'order_number' => $order->order_number,
            'customer_name' => $order->customer_name,
            'total_price' => $order->total_price,
        ]);
    }

    public function payment($id)
    {
        $order = \App\Models\Order::with('items.menuItem')->findOrFail($id);
        return view('order.payment', compact('order'));
    }

    public function processPayment(Request $request, $id)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:cash,bank_transfer,ewallet',
        ]);

        $order = \App\Models\Order::findOrFail($id);
        
        // Update order status to 'ready' (pembayaran diterima, siap diproses)
        $order->update([
            'status' => 'ready',
            'payment_method' => $validated['payment_method'],
            'completed_at' => now(),
        ]);

        // If AJAX request, return JSON
        if ($request->wantsJson()) {
            $paymentMethodLabel = [
                'cash' => 'Tunai',
                'bank_transfer' => 'Transfer Bank',
                'ewallet' => 'Dompet Digital'
            ];

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil diverifikasi',
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'customer_name' => $order->customer_name,
                'payment_method' => $paymentMethodLabel[$validated['payment_method']] ?? $validated['payment_method'],
                'total_price' => 'Rp ' . number_format($order->total_price, 0, ',', '.'),
                'status' => 'ready'
            ]);
        }

        return redirect()->route('order.receipt', $order->id)
            ->with('success', 'Pembayaran berhasil diverifikasi!');
    }

    public function history()
    {
        $orders = \App\Models\Order::with('items.menuItem')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('order.history', compact('orders'));
    }
}
