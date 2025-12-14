<?php 

use App\Models\admin\Category;

function getCategories() {
    return Category::with('subcategories')->get();
}