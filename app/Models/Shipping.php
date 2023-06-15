<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipping extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];

    public function provider()
    {
        return $this->belongsTo(ShippingProvider::class, 'shipping_provider_id');
    }
}
