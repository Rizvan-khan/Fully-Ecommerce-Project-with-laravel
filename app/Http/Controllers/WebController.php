<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin\Carausel;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use App\Models\WebLogo;

class WebController extends Controller
{
   public function index()
   {
      $slider = Carausel::all();
      //   $logo = WebLogo::all();
      //  $categories = Category::with('subcategories')->get();
      $category = Category::with(['subcategories.products'])->get();
      $products = Product::with(['category', 'subcategory'])->get();

      return view('welcome', compact('slider', 'products', 'category'));
   }


   public function product_detail(Request $request, $id)
   {

      $product_details = Product::findOrFail($id);


      return view('product-details', compact('product_details'));
   }


   public function all_product(Request $request, $id)
   {
      $query = Product::where('sub_category_id', $id);

      // 🔹 Price Filter
      if ($request->filled('min_price') && $request->filled('max_price')) {
         $query->whereBetween('price', [
            $request->min_price,
            $request->max_price
         ]);
      }

      // 🔹 Brand Filter
      if ($request->filled('brand')) {
         $query->whereIn('brand_id', $request->brand);
      }

      // 🔹 Sorting
      if ($request->sort == 'low_to_high') {
         $query->orderBy('price', 'asc');
      } elseif ($request->sort == 'high_to_low') {
         $query->orderBy('price', 'desc');
      } else {
         $query->latest();
      }

      // 🔹 Pagination (20 products per page)
      $all_product = $query->paginate(20)->withQueryString();

      $all_cate = Category::where('status', 1)
    ->with(['subcategories' => function ($q) {
        $q->where('status', 1);
    }])
    ->get();


      return view('all-product-details', compact('all_product','all_cate'));
   }
}
