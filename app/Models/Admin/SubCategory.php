<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = ['name','image','status','category_id'];


     public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    
     public function products()
    {
        return $this->hasMany(Product::class, 'sub_category_id');
    }


}
