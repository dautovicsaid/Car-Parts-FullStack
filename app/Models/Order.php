<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $perPage = 2;

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function isCompleted()
    {
        return $this->ordered_at != null;
    }

    protected $fillable = [
        'user_id',
        'ordered_at',
        'total_price',
    ];
}
