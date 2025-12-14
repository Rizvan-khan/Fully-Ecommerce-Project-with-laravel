<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'category_id', 'price',
        'quantity', 'sku', 'image', 'status','seller_id','sub_category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

     public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    // app/Models/Product.php
public function seller()
{
    return $this->belongsTo(User::class, 'seller_id'); 
}

}
