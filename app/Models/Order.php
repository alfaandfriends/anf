<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];

    public function shipping()
    {
        return $this->hasOne(Shipping::class)->latest();
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'customer_id');
    }

    public function status()
    {
        return $this->hasOne(OrderStatus::class)->latest();
    }
}
