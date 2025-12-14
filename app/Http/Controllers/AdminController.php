<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use App\Models\Admin\Carausel;
use App\Models\Admin\SubCategory;
use App\Models\WebLogo;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $Category = Category::count();
        $Product = Product::count();
        return view('admin.dashboard',compact('totalUsers','Category','Product'));
    }

     public function user()
    {
        return view('admin.user.add-user');
    }

 public function alluser()
{
    $alluser = User::all();
    return view('admin.user.all-user', compact('alluser'));
}

 // ✅ Store User
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,seller,user',
        ]);

        // ✅ Create user
        $user = new User();
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->password = Hash::make($request->password);
        $user->role     = $request->role;
        $user->save();

        return redirect()->back()->with('success', 'User added successfully!');
    }


      // ✅ Edit user form
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit-user', compact('user'));
    }

      // ✅ Update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:admin,seller,user',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->role  = $request->role;

        // Optional: Update password only if provided
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6']);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.user.all-user')->with('success', 'User updated successfully!');
    }


// add product start here

   public function product()
    {

        $procat = Category::all();


        return view('admin.product.add-product',compact('procat'));
    }

     public function category()
    {
        return view('admin.category.add-category');
    }

     // Category Store
    public function add_category(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/categories'), $imageName);
        }

        Category::create([
            'name'  => $request->name,
            'image' => $imageName,
            'status' => 1,
        ]);

        return redirect()->back()->with('success', 'Category added successfully!');
    }


     public function manage_category()
    {
            $allcat = Category::all();

        return view('admin.category.all-category',compact('allcat'));
    }


    public function edit_cat($id)
{
    $cat = Category::findOrFail($id);
    return view('admin.category.edit-category', compact('cat'));
}

public function update_cat(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $cat = Category::findOrFail($id);

    // Handle image update
    if ($request->hasFile('image')) {
        if ($cat->image && file_exists(public_path('uploads/categories/' . $cat->image))) {
            unlink(public_path('uploads/categories/' . $cat->image));
        }
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('uploads/categories'), $imageName);
        $cat->image = $imageName;
    }

    $cat->name = $request->name;
    $cat->status = $request->status;
    $cat->save();

    return redirect()->route('admin.manage-category')->with('success', 'Category updated successfully!');
}


public function destroy($id)
{
    $cat = Category::findOrFail($id);
    if ($cat->image && file_exists(public_path('uploads/categories/'.$cat->image))) {
        unlink(public_path('uploads/categories/'.$cat->image));
    }
    $cat->delete();
    return redirect()->back()->with('success', 'Category deleted successfully!');
}



    // Store new product
    public function add_product(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category_id' => 'required',
            'sub_category_id' => 'required',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/products'), $imageName);
            $data['image'] = 'uploads/products/'.$imageName;
        }

        Product::create($data);

        return redirect()->route('admin.product.add-product')->with('success', 'Product added successfully!');
    }

     public function edit_product($id)
    {
        $product = Product::findOrFail($id);
        $procat = Category::all();
        return view('admin.product.edit-product', compact('product', 'procat'));
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

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

     // Delete product
    public function destroy_product($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }
        $product->delete();

        return redirect()->route('admin.product.all-product')->with('success', 'Product deleted successfully!');
    }

  public function all_product()
    {
        $products = Product::with('category')->latest()->get();
        return view('admin.product.all-product', compact('products'));
    }

    public function slider()
    {
        
        return view('admin.slider.add-slider');
    }

     public function add_slider(Request $request)
    {
        $request->validate([
            'heading' => 'required',
            'description' => 'required',
           
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/slider'), $imageName);
            $data['image'] = 'uploads/slider/'.$imageName;
        }

        Carausel::create($data);

        return redirect()->route('admin.product.add-product')->with('success', 'Product added successfully!');
    }

     public function get_slider()
    {
        $Carausel = Carausel::all();
        return view('admin.slider.slider', compact('Carausel'));
    }


// subcategory code start
      public function subcat()
    {
        $category = Category::all();
        return view('admin.subcategory.add', compact('category'));
    }

    public function add_subcat(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/subcategory'), $imageName);
            $data['image'] = 'uploads/subcategory/'.$imageName;
        }

        SubCategory::create($data);

        return redirect()->route('admin.add-subcategory')->with('success', 'Sub Cateogery added successfully!');
    }


    public function getSubcategories($category_id)
{
    $subcategories = SubCategory::where('category_id', $category_id)->get();

    return response()->json($subcategories);
}



  public function manage_logo()
    {
        $logo = WebLogo::all();
        return view('admin.logo.manage-logo', compact('logo'));
    }
  public function edit_logo($id)
{
    $logo = WebLogo::findOrFail($id);
    return view('admin.logo.update-logo', compact('logo'));
}

 public function upload_logo(Request $request,$id)
{
   $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            
        ]);

          $logo = WebLogo::findOrFail($id);

          // Handle image update
    if ($request->hasFile('image')) {
        if ($logo->logo && file_exists(public_path('uploads/logo/' . $logo->logo))) {
            unlink(public_path('uploads/logo/' . $logo->logo));
        }
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('uploads/categories'), $imageName);
        $logo->logo = $imageName;
       
    }

    $logo->status = $request->status;
    $logo->save();

    return redirect()->route('admin.manage-logo')->with('success', 'Logo updated successfully!');


}






}
