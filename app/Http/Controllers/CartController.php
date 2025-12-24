<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\Admin\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User_detail;
use App\Models\User;
use App\Models\Order;
use App\Models\Order_item;

class CartController extends Controller
{



    public function addToCart(Request $request)
    {
        // Validation (simple)
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'qty' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0'
        ]);

        $productId = $data['product_id'];
        $quantity = $data['qty'] ?? 1;
        // $price = $data['price'] ?? 1;

        try {
            if (auth()->check()) {
                unset($data['price']);
                $userId = auth()->id();

                // If cart item already exists for user -> increment qty
                $cartItem = Cart::where('user_id', $userId)
                    ->where('product_id', $productId)
                    ->first();

                if ($cartItem) {
                    $cartItem->increment('qty', $quantity);
                } else {
                    Cart::create([
                        'user_id'    => $userId,
                        'product_id' => $productId,
                        'qty'        => $quantity

                    ]);
                }

                $count = Cart::where('user_id', $userId)->count();

                return response()->json([
                    'status'  => 'success',
                    'message' => 'Product added to cart (User Cart)',
                    'count'   => $count
                ]);
            }

            // Guest session cart
            $cart = session()->get('cart', []);

            if (isset($cart[$productId])) {
                $cart[$productId]['qty'] += $quantity;
            } else {
                $cart[$productId] = [
                    'product_id' => $productId,
                    'qty'        => $quantity,
                    'price'      => $data['price'] ?? 0
                ];
            }

            session()->put('cart', $cart);

            return response()->json([
                'status'  => 'success',
                'message' => 'Product added to cart (Guest Cart)',
                'count'   => count($cart)
            ]);
        } catch (\Exception $e) {
            // Log full error to laravel log for debugging
            \Log::error('Add to cart failed: ' . $e->getMessage(), [
                'product_id' => $productId,
                'qty' => $quantity,
                'user_id' => auth()->id() ?? null
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong while adding to cart.'
            ], 500);
        }
    }




    // get all cart product

    public function getAllCart()
    {
        $cartItems = [];

        // 1️⃣ User Logged in hai
        if (auth()->check()) {

            $user = auth()->user();

            $userCart = Cart::where('user_id', $user->id)->get();

            foreach ($userCart as $item) {

                $product = Product::find($item->product_id);

                $cartItems[] = [
                    "id"        => $item->id,   // DB id
                    "product_id" => $item->product_id,
                    "qty"       => $item->qty,

                    "name"      => $product->name ?? "Unknown Product",
                    "price"     => $product->price ?? 0,
                    "image"     => $product->image ? asset($product->image) : asset("default.png"),
                    "slug"      => $product->slug ?? "",
                    "stock"     => $product->stock ?? 0,
                ];
            }
        }

        // 2️⃣ Guest user (session cart)
        else {

            $sessionCart = session('cart', []);

            foreach ($sessionCart as $key => $item) {

                $product = Product::find($item['product_id']);

                $cartItems[] = [
                    "id"        => $key,   // Session key
                    "product_id" => $item['product_id'],
                    "qty"       => $item['qty'],

                    "name"      => $product->name ?? "Unknown Product",
                    "price"     => $product->price ?? 0,
                    "image"     => $product->image ? asset($product->image) : asset("default.png"),
                    "slug"      => $product->slug ?? "",
                    "stock"     => $product->stock ?? 0,
                ];
            }
        }

        return response()->json([
            "status" => true,
            "cart"   => $cartItems
        ]);
    }


    public function remove(Request $request)
    {
        $product_id = $request->product_id;
        // 🔥 1. If user is logged in → database cart
        if (auth()->check()) {
            $user_id = auth()->id();
            // delete cart row
            \DB::table('carts')->where('user_id', $user_id)
                ->where('product_id', $product_id)
                ->delete();

            // updated cart
            $cart = \DB::table('carts')->where('user_id', $user_id)->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Item removed from cart.',
                'cart_count' => $cart->count(),
                'total_amount' => $cart->sum('total_price'),
            ]);
        }

        // 🔥 2. If user is NOT logged in → Session cart
        $cart = session()->get('cart', []);

        if (isset($cart[$product_id])) {
            unset($cart[$product_id]);
            session()->put('cart', $cart);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Item removed from cart.',
            'cart_count' => count($cart),
            'total_amount' => array_sum(array_column($cart, 'total_price'))
        ]);
    }

    public function count()
    {
        // 1) Login user → DB count
        if (auth()->check()) {
            $count = Cart::where('user_id', auth()->id())->sum('qty');

            return response()->json([
                'count' => $count
            ]);
        }

        // 2) Guest user → Session count
        $cart = session('cart', []);
        $count = 0;

        foreach ($cart as $item) {
            $count += isset($item['qty']) ? (int)$item['qty'] : 1;
        }

        return response()->json([
            'count' => $count
        ]);
    }


    public function totalAmount()
    {
        // 1) Logged-in User (DB Cart)
        if (auth()->check()) {

            $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();

            $totalAmount = 0;

            foreach ($cartItems as $item) {
                $price = $item->product->price;  // 🎯 Product table price
                $totalAmount += ($price * $item->qty);
            }

            return response()->json([
                'total_amount' => $totalAmount
            ]);
        }

        // 2) Guest User (Session Cart)
        $cart = session('cart', []);
        $totalAmount = 0;

        foreach ($cart as $item) {

            // price session me old ho sakta hai → product table se fetch karo
            $product = Product::find($item['product_id']);

            if ($product) {
                $price = $product->price;   // 🎯 Product table price
            } else {
                $price = 0;
            }

            $qty = isset($item['qty']) ? (int)$item['qty'] : 1;

            $totalAmount += ($qty * $price);
        }

        return response()->json([
            'total_amount' => $totalAmount
        ]);
    }



    public function getallmodalproductwithproductid(Request $request)
    {
        $product_id = $request->product_id;

        $product = Product::find($product_id);

        if (!$product) {
            return response()->json([
                "status" => false,
                "message" => "Product not found"
            ]);
        }

        return response()->json([
            "status" => true,
            "product" => [
                "id"        => $product->id,
                "name"      => $product->name,
                "price"     => $product->price,
                "image"     => $product->image ? asset($product->image) : asset('default.png'),
                "slug"      => $product->slug,
                "stock"     => $product->quantity,
                "description" => $product->description ?? "",
            ]
        ]);
    }



    public function decreaseQty(Request $request)
    {
        $product_id = $request->product_id;

        // ======= IF USER LOGGED IN → DB CART =======
        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->id())
                ->where('product_id', $product_id)
                ->first();

            if ($cart) {
                if ($cart->qty > 1) {
                    $cart->qty -= 1;
                    $cart->save();
                } else {
                    $cart->delete();
                }
            }

            return response()->json(['status' => 'success']);
        }

        // ======= ELSE USER NOT LOGGED IN → SESSION CART =======
        $cart = session()->get('cart', []);

        if (isset($cart[$product_id])) {
            if ($cart[$product_id]['qty'] > 1) {
                $cart[$product_id]['qty']--;
            } else {
                unset($cart[$product_id]);
            }

            session()->put('cart', $cart);
        }

        return response()->json(['status' => 'success']);
    }


    public function increaseQty(Request $request)
    {
        $product_id = $request->product_id;

        // ======= LOGGED-IN USER → DB CART =======
        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->id())
                ->where('product_id', $product_id)
                ->first();

            if ($cart) {
                $cart->qty += 1;
                $cart->save();
            }

            return response()->json(['status' => 'success']);
        }

        // ======= GUEST USER → SESSION CART =======
        $cart = session()->get('cart', []);

        if (isset($cart[$product_id])) {
            $cart[$product_id]['qty']++;
            session()->put('cart', $cart);
        }

        return response()->json(['status' => 'success']);
    }



    public function checkout()
    {
        $user = auth()->user(); // logged in user data

        // Cart data fetch (user specific)
        // $cartItems = Cart::where('user_id', $user->id)->get();

        return view('checkout', compact('user'));
    }



    public function addToWishlist(Request $request)
    {
        // Validation (simple)
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'qty' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0'
        ]);

        $productId = $data['product_id'];
        $quantity = $data['qty'] ?? 1;
        $price = $data['price'] ?? 1;

        try {
            if (auth()->check()) {
                unset($price);
                $userId = auth()->id();

                // If cart item already exists for user -> increment qty
                $cartItem = Wishlist::where('user_id', $userId)
                    ->where('product_id', $productId)
                    ->first();

                if ($cartItem) {
                    $cartItem->increment('qty', $quantity);
                } else {
                    Wishlist::create([
                        'user_id'    => $userId,
                        'product_id' => $productId,
                        'qty'        => $quantity

                    ]);
                }

                $count = Wishlist::where('user_id', $userId)->count();

                return response()->json([
                    'status'  => 'success',
                    'message' => 'Product added to Wishlist (User Cart)',
                    'count'   => $count
                ]);
            }

            // Guest session cart
            $cart = session()->get('wishlist', []);

            if (isset($cart[$productId])) {
                $cart[$productId]['qty'] += $quantity;
            } else {
                $cart[$productId] = [
                    'product_id' => $productId,
                    'qty'        => $quantity,
                    'price'      => $price,
                ];
            }

            session()->put('wishlist', $cart);

            return response()->json([
                'status'  => 'success',
                'message' => 'Product added to Wishlist (Guest Cart)',
                'count'   => count($cart)
            ]);
        } catch (\Exception $e) {
            // Log full error to laravel log for debugging
            \Log::error('Add to cart failed: ' . $e->getMessage(), [
                'product_id' => $productId,
                'qty' => $quantity,
                'user_id' => auth()->id() ?? null
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong while adding to cart.'
            ], 500);
        }
    }


    public function wishlistCount()
    {
        // 1) Login user → DB count
        if (auth()->check()) {
            $count = Wishlist::where('user_id', auth()->id())->sum('qty');

            return response()->json([
                'count' => $count
            ]);
        }

        // 2) Guest user → Session count
        $cart = session('wishlist', []);
        $count = 0;

        foreach ($cart as $item) {
            $count += isset($item['qty']) ? (int)$item['qty'] : 1;
        }

        return response()->json([
            'count' => $count
        ]);
    }


    public function wishlistitem()
    {
        return view('wishlist');
    }


    public function getAllwishlistproduct()
    {
        $cartItems = [];

        // 1️⃣ User Logged in hai
        if (auth()->check()) {

            $user = auth()->user();

            $userCart = Wishlist::where('user_id', $user->id)->get();

            foreach ($userCart as $item) {

                $product = Product::find($item->product_id);

                $cartItems[] = [
                    "id"        => $item->id,   // DB id
                    "product_id" => $item->product_id,
                    "qty"       => $item->qty,

                    "name"      => $product->name ?? "Unknown Product",
                    "price"     => $product->price ?? 0,
                    "image"     => $product->image ? asset($product->image) : asset("default.png"),
                    "slug"      => $product->slug ?? "",
                    "stock"     => $product->stock ?? 0,
                ];
            }
        }

        // 2️⃣ Guest user (session cart)
        else {

            $sessionCart = session('wishlist', []);

            foreach ($sessionCart as $key => $item) {

                $product = Product::find($item['product_id']);

                $cartItems[] = [
                    "id"        => $key,   // Session key
                    "product_id" => $item['product_id'],
                    "qty"       => $item['qty'],

                    "name"      => $product->name ?? "Unknown Product",
                    "price"     => $product->price ?? 0,
                    "image"     => $product->image ? asset($product->image) : asset("default.png"),
                    "slug"      => $product->slug ?? "",
                    "stock"     => $product->stock ?? 0,
                ];
            }
        }

        return response()->json([
            "status" => true,
            "wishlist"   => $cartItems
        ]);
    }


    public function removewish(Request $request)
    {
        Wishlist::where('id', $request->id)
            ->where('user_id', auth()->id())
            ->delete();

        return response()->json([
            'status' => true,
            'message' => 'Item removed from wishlist'
        ]);
    }


    public function saveDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'address'  => 'required',
            'pin_code' => 'required',
            'country'  => 'required',
            'state'    => 'required',
            'district' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        auth()->user()->update([
            'name' => $request->name
        ]);

        User_detail::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'address'  => $request->address,
                'name'  => $request->name,
                'district' => $request->district,
                'state'    => $request->state,
                'country'  => $request->country,
                'pin_code' => $request->pin_code,
            ]
        );

        return response()->json([
            'status'   => true,
            'redirect' => route('checkout.review')
        ]);
    }


    public function checkout_review()
    {
        $user = auth()->user();
        return view('checkout-review', compact('user'));
    }

    public function cashOnDelivery(Request $request)
    {

        $user = auth()->user();

        // 1️⃣ Fetch user cart
        $cartItems = Cart::where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Cart is empty');
        }

        DB::beginTransaction();

        try {

            // 2️⃣ Calculate subtotal
            $subtotal = 0;
            foreach ($cartItems as $item) {
                $product = Product::findOrFail($item->product_id);
                $subtotal += $product->price * $item->qty;
            }

            $tax = 0;
            $shipping = 0;
            $discount = 0;
            $total = $subtotal + $tax + $shipping - $discount;

            // 3️⃣ Create order
            $order = Order::create([
                'order_number'    => 'ORD' . time(),
                'user_id'         => $user->id,
                'payment_method'  => 'COD',
                'payment_status'  => 'pending',
                'order_status'    => 'confirmed',
                'subtotal'        => $subtotal,
                'tax'             => $tax,
                'shipping_charge' => $shipping,
                'discount'        => $discount,
                'total_amount'    => $total,
                'currency'        => 'INR',

                // User snapshot
                'name'    => $request->name,
                'email'   => $user->email ?? '',
                'phone'   => $user->mobile ?? '',

                'address' => $request->address,
                'city'    => $request->district,
                'state'   => $request->state ?? '',
                'pincode' => $request->pin_code,
                'country' => $request->country,
            ]);

            // 4️⃣ Create order items
            foreach ($cartItems as $item) {

                $product = Product::findOrFail($item->product_id);

                Order_item::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'price'      => $product->price, // ✅ product table se
                    'qty'        => $item->qty,
                    'total'      => $product->price * $item->qty,
                ]);
            }

            // 5️⃣ Clear cart
            Cart::where('user_id', $user->id)->delete();

            DB::commit();

            // 6️⃣ Success redirect
            return redirect()->route('order-success', $order->id)
                ->with('success', 'Order placed successfully (Cash on Delivery)');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage()); // Debug error, remove in production
        }
    }
}
