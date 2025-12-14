<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Product;


class Wishlist extends Model
{
      protected $fillable = [
        'user_id',
        'product_id',
        'qty',
    ];


public function product()
{
    return $this->belongsTo(Product::class);
}
}
