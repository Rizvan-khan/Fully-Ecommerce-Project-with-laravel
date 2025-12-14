<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin\Carausel;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use App\Models\WebLogo;

class WebController extends Controller
{
   public function index(){
    $slider = Carausel::all();
   //   $logo = WebLogo::all();
   //  $categories = Category::with('subcategories')->get();
     $category = Category::with(['subcategories.products'])->get();
    $products = Product::with(['category', 'subcategory'])->get();
   
    return view('welcome',compact('slider','products','category'));
   }


   


}
