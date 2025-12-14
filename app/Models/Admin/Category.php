<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{

    use HasFactory;
     protected $fillable = [
        'name',
        'image',
        'status',
    ];

     public function subcategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id');
    }

   

     public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }


}
