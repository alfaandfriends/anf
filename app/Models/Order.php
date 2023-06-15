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

    public function shippings()
    {
        return $this->hasMany(Shipping::class);
    }

    public function status()
    {
        return $this->hasOne(OrderStatus::class)->latest();
    }
}
