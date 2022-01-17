<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product; //To use the model from product
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Cart; //Shopping Cart Implementation


class PagesController extends Controller
{
    public function initializeCart()
    {
        if(Auth::check())
        {
            Cart::instance('cart')->store(Auth::user()->email);
        }
    }

    public function restoreCart()
    {
        if(Auth::check())
        {
            Cart::instance('cart')->restore(Auth::user()->email);
        }
    }

    //Cart Functions Cart Controller
    public function cart(Request $request)
    {
        $request->session()->forget('cart');
        $this->restoreCart();
        // Delete from cart the out of stocks item
        if(Cart::instance('cart')->content()->count() > 0)
        {
            foreach(Cart::instance('cart')->content() as $items)
            {
                $rowId= $items->rowId;
                $stock_count = $items->model->product_stock;
    
                if($stock_count == 0 )
                {
                    Cart::instance('cart')->remove($rowId);
                }
            }
        }

        $this->initializeCart();

        $title="My Cart"; 
       
        $products = Product::orderBy('product_name','asc')->get(); // sort by name
        $data = array
        (
            'title' => $title ,
            'products' =>  $products
        );
   
   
        return view('pages.cart')->with($data);
    }

    public function increaseItemQty(Request $request)
    {
        $this->validate($request,[
            'cartID' => 'required'
        ]);
        
        $rowID = $request->input('cartID');
        $product = Cart::instance('cart')->get($rowID);
        $qty = $product->qty + 1;
        Cart::instance('cart')->update($rowID, $qty);
        $subtotal = Cart::instance('cart')->subtotal();
        $new_quantity = $product->qty;
        $data = array
        (
            'subtotal' => $subtotal ,
            'new_quantity' =>  $new_quantity
        );
        
        $this->initializeCart();
        return $data;
    }

    public function decreaseItemQty(Request $request)
    {
        $this->validate($request,[
            'cartID' => 'required'
        ]);
        $rowID = $request->input('cartID');
        $product = Cart::instance('cart')->get($rowID);
        $qty = $product->qty - 1;
        Cart::instance('cart')->update($rowID, $qty);
        $subtotal = Cart::instance('cart')->subtotal();
        $new_quantity = $product->qty;
        $data = array
        (
            'subtotal' => $subtotal ,
            'new_quantity' =>  $new_quantity
        );
        $this->initializeCart();

        return $data;
    }

    public function setNumItemQty(Request $request)
    {
        $this->validate($request,[
            'cartID' => 'required',
            'qty' => 'required'
        ]);
        
        $rowID = $request->input('cartID');
        $product = Cart::instance('cart')->get($rowID);
        $qty = $request->input('qty');
        Cart::instance('cart')->update($rowID, $qty);
        $subtotal = Cart::instance('cart')->subtotal();
        $new_quantity = $product->qty;
        $data = array
        (
            'subtotal' => $subtotal ,
            'new_quantity' =>  $new_quantity
        );
        
        $this->initializeCart();


        return $data;
    }
    
    public function addToCart(Request $request)
    {
        
        if (Auth::check())
        {   
            $product_id = $request->product_id;
            $product_name = $request->product_name;
            $product_price = $request->product_price;
    
            Cart::instance('cart')->add($product_id,$product_name,1,$product_price)
                                    ->associate('App\Models\Product');
            $this->initializeCart();

            return redirect()->route('pages.cart')->with('success','Item Added to Cart Successfully');;
        }

        else
        {
            return redirect('login');
        }

        
    }

    public function removeFromCart(Request $request)
    {
        $rowId = $request->rowId;

        Cart::instance('cart')->remove($rowId);
        $this->initializeCart();
        
        return redirect()->route('pages.cart')->with('success','Item Removed From Cart Successfully');;

    }
    
    // Show Pages Admin Controller

    public function showAccountManagement()
    {
        $registered_accounts = User::where('user_type', '=', 'user')->count();
        $users = User::where('user_type', '=', 'user')
                        ->orderBy('first_name','asc')
                        ->get();
        $data = array
        (
            'users' =>  $users,
            'registered_accounts' =>  $registered_accounts,
            'title' =>  'Account Management'
        );
        return view('admin.accounts')->with($data);
    }

    public function showInventory()
    {
        $products = Product::orderBy('product_name','asc')->get(); // sort by name
        $product_categories = ProductCategory::orderBy('product_category','asc')->get(); // sort by name
        $low_on_stock= Product::where('product_stock', '<', '20')->count();
        $items_listed= Product::count();
        
        $data = array
        (
            'products' =>  $products,
            'product_categories' =>  $product_categories,
            'low_on_stock' =>  $low_on_stock,
            'items_listed' =>  $items_listed,
            'title' =>  'Inventory Management'
        );
        return view('admin.inventory')->with($data);
    }

    public function showOrderAll()
    {   
        $orders = Order::orderBy('created_at','asc')->get();
        $pending_orders= Order::where('status', '=', 'ordered')->count();
        $being_delivered= Order::where('status', '=', 'shipped')->count();
        $delivered_orders= Order::where('status', '=', 'delivered')->count();
        $canceled_orders= Order::where('status', '=', 'canceled')->count();
        $total_orders= Order::count();

        $data = array
        (
            'orders' =>  $orders,
            'pending_orders' =>  $pending_orders,
            'being_delivered' =>  $being_delivered,
            'delivered_orders' =>  $delivered_orders,
            'canceled_orders' =>  $canceled_orders,
            'total_orders' =>  $total_orders,
            'title' =>  'Order and Delivery Management'
        );
        return view('admin.order')->with($data);
    }

    //Checkout Page
    public function showCheckOut(Request $request)
    {
        $request->session()->forget('cart');
        $this->restoreCart();

        // Delete from cart the out of stocks item
        foreach(Cart::instance('cart')->content() as $items)
        {
            $rowId= $items->rowId;
            $stock_count = $items->model->product_stock;

            if($stock_count == 0 )
            {
                Cart::instance('cart')->remove($rowId);
            }
        }
        $this->initializeCart();
        
        $current_user_id = auth()->user()->id;
        $user = User::find($current_user_id);
        $data = array
        (
            'current_user' =>  $user,
            'title' =>  'Checkout'
        );
        return view('pages.checkout')->with($data);
    }

    //Store Page
    public function showProducts()
    {
        $this->restoreCart();
        $title = 'Koop Hardware Online Store';
        $products = Product::where('product_stock', '>', 0)
                            ->orderBy('product_name','asc')
                            ->paginate(12,['*'], 'products'); // sort by name
        $product_categories = ProductCategory::orderBy('product_category','asc')->get(); // sort by name

        $data = array
        (
            'products' =>  $products,
            'product_categories' => $product_categories,
            'title' => $title
        );

        return view('pages.index')->with($data);
    }

    //Landing Page
    public function showLanding()
    {
        $title = 'Koop Hardware Online Store';

        return view('pages.landing')->with($title);
    }

}
