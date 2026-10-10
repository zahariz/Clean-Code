<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'payment_status',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
        'payment_status' => PaymentStatus::class,
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match (true) {
            $this->status == OrderStatus::DRAFT
                && $this->payment_status == PaymentStatus::PAID
                && $this->total_amount > 2000000 => 'VIP Paid',

            $this->status == OrderStatus::DRAFT
                && $this->payment_status == PaymentStatus::PAID => 'Paid',

            $this->status == OrderStatus::DRAFT => 'Waiting Payment',

            $this->status == OrderStatus::PROCESSING => 'Processing',

            default => 'Cancelled',
        };
    }
}
