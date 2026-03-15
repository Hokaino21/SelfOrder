<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

/**
 * OrderCreated Event
 * 
 * This event is fired whenever a new order is created.
 * It can be broadcast to real-time listeners via Pusher/Echo if configured.
 */
class OrderCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Order
     */
    public $order;

    /**
     * Create a new event instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        // public channel since we don't require authentication for admin
        return new Channel('orders');
    }

    public function broadcastAs()
    {
        return 'OrderCreated';
    }

    public function broadcastWith()
    {
        // map order to simple array used by frontend
        $o = $this->order;
        return [
            'order' => [
                'id' => $o->id,
                'order_number' => $o->order_number,
                'customer_name' => $o->customer_name,
                'customer_phone' => $o->customer_phone,
                'status' => $o->status,
                'total_price' => $o->total_price,
                'items_count' => $o->items()->count(),
                'created_at' => $o->created_at->format('d/m/Y H:i'),
            ],
            'stats' => [
                'pending' => Order::where('status', 'pending')->count(),
                'preparing' => Order::where('status', 'preparing')->count(),
                'ready' => Order::where('status', 'ready')->count(),
                'completed' => Order::where('status', 'completed')->count(),
            ],
        ];
    }
}
