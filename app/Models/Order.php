<?php

namespace App\Models;

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
            $this->status === 1 && $this->payment_status === 'PAID' && $this->total_amount > 2000000 => 'VIP Paid',
            $this->status === 1 && $this->payment_status === 'PAID' => 'Paid',
            $this->status === 1 => 'Waiting Payment',
            $this->status === 2 => 'Processing',
            default => 'Cancelled',
        };
    }
}
