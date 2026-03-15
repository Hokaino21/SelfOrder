<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_number', 'customer_name', 'customer_phone', 'status', 'payment_method', 'total_price', 'notes', 'ordered_at', 'completed_at'];

    /**
     * Dispatch broadcast events when orders are created or updated.
     */
    protected static function booted()
    {
        static::created(function ($order) {
            event(new \App\Events\OrderCreated($order));
        });

        static::updated(function ($order) {
            event(new \App\Events\OrderUpdated($order));
        });
    }

    protected $casts = [
        'ordered_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateOrderNumber()
    {
        $date = now()->format('Ymd');
        $count = self::whereDate('created_at', today())->count() + 1;
        return 'ORD-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
