<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Simple hardcoded credentials (in production, use database)
        if ($validated['username'] === 'admin' && $validated['password'] === 'admin123') {
            session(['admin_authenticated' => true, 'admin_name' => 'Admin']);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['credentials' => 'Username atau password salah.']);
    }

    public function dashboard()
    {
        if (!session('admin_authenticated')) {
            return redirect()->route('admin.login');
        }

        // show all orders initially; the JavaScript will handle updates
        // you can add pagination later if the table becomes too large
        $orders = Order::with('items.menuItem')
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'pending' => Order::where('status', 'pending')->count(),
            'preparing' => Order::where('status', 'preparing')->count(),
            'ready' => Order::where('status', 'ready')->count(),
            'completed' => Order::where('status', 'completed')->count(),
        ];

        return view('admin.dashboard', compact('orders', 'stats'));
    }

    public function updateStatus(Request $request, $id)
    {
        if (!session('admin_authenticated')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,preparing,ready,completed,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $validated['status']]);

        return response()->json([
            'status' => 'success',
            'message' => 'Status pesanan diperbarui',
            'order' => $order
        ]);
    }

    public function getDashboardData()
    {
        if (!session('admin_authenticated')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // fetch every order (could be paginated if you have huge volume)
        $orders = Order::with('items.menuItem')
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'pending' => Order::where('status', 'pending')->count(),
            'preparing' => Order::where('status', 'preparing')->count(),
            'ready' => Order::where('status', 'ready')->count(),
            'completed' => Order::where('status', 'completed')->count(),
        ];

        return response()->json([
            'stats' => $stats,
            'orders' => $orders->map(function($order) {
                return [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'customer_name' => $order->customer_name,
                    'customer_phone' => $order->customer_phone,
                    'status' => $order->status,
                    'total_price' => $order->total_price,
                    'items_count' => $order->items->count(),
                    'created_at' => $order->created_at->format('d/m/Y H:i'),
                ];
            })
        ]);
    }

    public function deleteOrder(Request $request, $id)
    {
        if (!session('admin_authenticated')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $order = Order::findOrFail($id);
        
        // Delete associated order items first
        $order->items()->delete();
        
        // Delete the order
        $order->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Pesanan berhasil dihapus'
        ]);
    }

    public function logout()
    {
        session()->forget(['admin_authenticated', 'admin_name']);
        return redirect()->route('admin.login');
    }
}
