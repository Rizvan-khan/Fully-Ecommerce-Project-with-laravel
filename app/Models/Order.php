<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Order_item; 


class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',

        'payment_method',
        'payment_status',
        'payment_id',
        'payer_id',

        'subtotal',
        'tax',
        'shipping_charge',
        'discount',
        'total_amount',
        'currency',

        'order_status',

        'name',
        'email',
        'phone',

        'address',
        'city',
        'state',
        'pincode',
        'country',

        'paypal_response',
    ];

    public function items()
    {
        return $this->hasMany(Order_item::class);
    }
}
