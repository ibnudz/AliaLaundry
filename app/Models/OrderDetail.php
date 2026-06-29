<?php

namespace App\Models;

use Database\Factories\OrderDetailFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['order_id', 'service_id', 'quantity', 'price'])]
class OrderDetail extends Model
{
    /** @use HasFactory<OrderDetailFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
            'price' => 'decimal:2',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    protected static function booted(): void
    {
        static::saved(function (OrderDetail $detail) {
            $order = $detail->order;
            if ($order) {
                $total = $order->orderDetails()
                    ->selectRaw('COALESCE(SUM(quantity * price), 0) as total')
                    ->value('total');
                $order->update(['total_price' => $total]);
            }
        });

        static::deleted(function (OrderDetail $detail) {
            $order = $detail->order;
            if ($order) {
                $total = $order->orderDetails()
                    ->selectRaw('COALESCE(SUM(quantity * price), 0) as total')
                    ->value('total');
                $order->update(['total_price' => $total]);
            }
        });
    }
}
