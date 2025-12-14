<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use Illuminate\Support\Facades\Auth;


class SellerController extends Controller
{
      public function index()
    {

            if (Auth::user()->role == 'seller') {

        $seller_id = Auth::id();
    $totalUsers = User::where('role','user')->count();
        $producttotal = Product::where('seller_id',$seller_id)->count();
        return view('seller.dashboard',compact('totalUsers','producttotal'));
    }
}

     public function product()
    {
   
       
        $cat = Category::all();
        return view('seller.product.add-product',compact('cat'));
    }

    public function add_product(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category_id' => 'required',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/products'), $imageName);
            $data['image'] = 'uploads/products/'.$imageName;
        }


         // 👉 Auth user ke role ke hisab se seller_id set karna
    if (Auth::user()->role == 'seller') {
        $data['seller_id'] = Auth::id();   // logged-in seller ka ID
    } else {
        // agar admin add kar raha hai toh seller_id optional ya choose karwana padega
        $data['seller_id'] = $request->seller_id ?? null;
    }


        Product::create($data);

        return redirect()->route('seller.product.add-product')->with('success', 'Product added successfully!');
    }


 public function all_product()
{
    if (Auth::user()->role == 'seller') {

        $seller_id = Auth::id(); 
        
        // dd($seller_id);
        // logged-in seller ID

        $products = Product::where('seller_id', $seller_id)
            ->with('category')
            ->latest()
            ->get();

    }

    return view('seller.product.all-product', compact('products'));
}



  public function edit_product($id)
    {
        $product = Product::findOrFail($id);
        $procat = Category::all();
        return view('seller.product.edit-product', compact('product', 'procat'));
    }

      public function update_product(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category_id' => 'required',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/products'), $imageName);
            $data['image'] = 'uploads/products/'.$imageName;
        }

        $product->update($data);

        return redirect()->route('seller.products.all-product')->with('success', 'Product updated successfully!');
    }

     // Delete product
    public function destroy_product($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }
        $product->delete();

        return redirect()->route('seller.product.all-product')->with('success', 'Product deleted successfully!');
    }


}
