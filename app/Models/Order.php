<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'user_id',
    'order_code',
    'total_amount',
    'shipping_address',
    'status',
    'payment_status',
    'payment_method',
    'payment_proof',
    'notes'
])]
class Order extends Model
{
    use HasFactory;

    protected $casts = [
        'total_amount' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Status helpers for views
    public function getStatusBadgeClassAttribute()
    {
        return match ($this->status) {
            'pending' => 'bg-warning text-dark',
            'processing' => 'bg-info text-white',
            'completed' => 'bg-success text-white',
            'cancelled' => 'bg-danger text-white',
            default => 'bg-secondary text-white',
        };
    }

    public function getPaymentStatusBadgeClassAttribute()
    {
        return match ($this->payment_status) {
            'unpaid' => 'bg-danger text-white',
            'paid' => 'bg-success text-white',
            'waiting_verification' => 'bg-warning text-dark',
            default => 'bg-secondary text-white',
        };
    }
}
