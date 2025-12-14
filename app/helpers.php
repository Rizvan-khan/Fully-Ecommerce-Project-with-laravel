<?php 

use App\Models\admin\Category;

use App\Models\WebLogo;

function getCategories() {
    return Category::with('subcategories')->get();
}


if (!function_exists('siteLogo')) {
    function siteLogo()
    {
        return WebLogo::where('status', 1)->first();
    }
}