<?php

namespace App\Http\Controllers;

use App\Events\OrderPlaced;
use App\Events\OrderUpdated;
use Illuminate\Http\Request;
use App\Jobs\SendEmail;
use App\Jobs\SendOrderUpdateEmail;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderMail;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Carbon;
use App\Models\Product; //To use the model from product
use Illuminate\Support\Facades\Auth;
use Cart; //Shopping Cart Implementation

class OrdersController extends Controller
{
    //

    public function initializeCart()
    {
        if(Auth::check())
        {
            Cart::instance('cart')->store(Auth::user()->email);
        }
    }

    public function orderConfirmationEmail($order)
    {
        dispatch(new SendEmail($order));
    }

    public function orderUpdateEmail($message, $recipient)
    {
        dispatch(new SendOrderUpdateEmail($message, $recipient));
    }

    public function placeOrder(Request $request)
    {
        $current_user_id = auth()->user()->id;
        $user = User::find($current_user_id);

        //Check all items if quantity is lower or equal to stock
        foreach(Cart::instance('cart')->content() as $item)
        {
            $product_id = $item->id;
            $checkOutItem = Product::find($product_id);
            $checkOutQuantity = $item->qty; //Quantity to Checkout
            $checkOutItem_current_stock = $checkOutItem->product_stock; //Available Product Stocks
                        
            if($checkOutQuantity > $checkOutItem_current_stock)
            {
                return redirect('/cart')->with('error','Order Exceeded Maximum Stocks Available');
            }
        }

        //Order to Order Database
        $order = new Order();
        $order->user_id = $current_user_id;
        $order->tax = Cart::instance('cart')->subtotal(2,'.','') * 0.12;
        $order->subtotal = Cart::instance('cart')->subtotal(2,'.','') - $order->tax;
        $order->total =  Cart::instance('cart')->subtotal(2,'.','');
        $order->status = 'ordered';
        $order->first_name = $user->first_name;
        $order->middle_initial = $user->middle_initial;
        $order->last_name = $user->last_name;
        $order->mobile = $user->mobile;
        $order->email = $user->email;
        $order->address = $user->barangay .', '.$user->city.' City. '. $user->address_notes;

        $order->save();

        //Cart Contents to Order Items Database and Decrease Item Quantity
        foreach(Cart::instance('cart')->content() as $item)
        {
            $orderItem = new OrderItem();
            $orderItem->product_id = $item->id;
            $orderItem->order_id = $order->id;
            $orderItem->price = $item->subtotal;
            $orderItem->quantity = $item->qty;
            $orderItem->save();

            $product_id = $item->id;
            $checkOutItem = Product::find($product_id);
            $checkOutQuantity = $item->qty; //Quantity to Checkout
            $checkOutItem_current_stock = $checkOutItem->product_stock; //Available Product Stocks
            $checkOutItem_new_stock = $checkOutItem_current_stock - $checkOutQuantity; // Deduct checked out items from current stock
            $checkOutItem->product_stock = $checkOutItem_new_stock; // Deduct checked out items from current stock
            $checkOutItem->save();
        }

        //Clear Cart Contents
        Cart::instance('cart')->destroy();
        $this->initializeCart();

        //Send Email Confirmation
        $this->orderConfirmationEmail($order);

        //Send Notification to Administrator
        $text = $order->first_name.' '.$order->middle_initial.'. '.$order->last_name.' has placed an order';
        
        $message = array
        (
            'order_id' =>  $order->id,
            'text' =>  $text
        );
        
        event(new OrderPlaced($message));


        return redirect('user/orders/ordered')->with('success','Check Out Successful');
    }

    public function deleteOrder(Request $request)
    {
        $this->validate($request,[
            'delete_order_id' => 'required',
            'delete_order_name' => 'required'
        ]);
        $order_id = $request->input('delete_order_id');
        $order_id = Order::find($order_id);
        $order_id->delete();
        
        return back()->with('success','Order Record Deleted Successfully');
    }

    //Show Orders Sorted by Status
    public function showOrderOrdered(Request $request)
    {
        $orders = Order::where('status', '=', 'ordered')
                        ->orderBy('created_at','asc')->get();
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

    public function showOrderShipped(Request $request)
    {
        $orders = Order::where('status', '=', 'shipped')
                        ->orderBy('created_at','asc')->get();
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

    public function showOrderDelivered(Request $request)
    {
        $orders = Order::where('status', '=', 'delivered')
                        ->orderBy('created_at','asc')->get();
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

    public function showOrderCanceled(Request $request)
    {
        $orders = Order::where('status', '=', 'canceled')
                        ->orderBy('created_at','asc')->get();
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

    // Show one specific order
    public function showOrder($id)
    {
        //Show only one specific info
        $orders = Order::where('id', '=', $id)->orderBy('created_at','asc')->get();
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

    //Show orders by users
    public function showUserOrder($id)
    {
        $orders = Order::where('user_id', '=', $id)
                        ->orderBy('created_at','asc')->get();
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

    //Show orders Today
    public function showTodaySales()
    {   
        $orders= Order::where('status', '=', 'delivered')->whereDate('created_at', Carbon::today())
                        ->orderBy('created_at','asc')->get();
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

    //Show orders Total Delivered
    public function showTotalSales()
    {   
        $orders= Order::where('status', '=', 'delivered')->orderBy('created_at','asc')->get();
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

    // Update Order Status
    public function updateStatusOrdered(Request $request)
    {
        $this->validate($request,[
            'order_id' => 'required'
        ]);

        $order_id = $request->input('order_id');
        $order = Order::find($order_id);
        $order->status = 'ordered';
        $order->save();
        
        $message = 'Hello, '. $order->first_name .' '. $order->middle_initial .'. '. $order->last_name . '. Your Order with Order ID # '.$order->id.' has been successfully ordered.';
        $recipient = $order->email;

        //Send Email
        $this->orderUpdateEmail($message, $recipient);

        return back()->with('success','Order Status Updated Successfully');

    }

    public function updateStatusShipped(Request $request)
    {
        $this->validate($request,[
            'order_id' => 'required'
        ]);

        $order_id = $request->input('order_id');
        $order = Order::find($order_id);
        $order->status = 'shipped';
        $order->save();

        $message = 'Hello, '. $order->first_name .' '. $order->middle_initial .'. '. $order->last_name . '. Your Order with Order ID # '.$order->id.' has been successfully shipped out.';
        $recipient = $order->email;

        $this->orderUpdateEmail($message, $recipient);
        return back()->with('success','Order Status Updated Successfully');
    }

    public function updateStatusDelivered(Request $request)
    {
        $this->validate($request,[
            'order_id' => 'required'
        ]);

        $order_id = $request->input('order_id');
        $order = Order::find($order_id);
        $order->status = 'delivered';
        $order->save();

        $message = 'Hello, '. $order->first_name .' '. $order->middle_initial .'. '. $order->last_name . '. Your Order with Order ID # '.$order->id.' has been successfully delivered.';
        $recipient = $order->email;

        $this->orderUpdateEmail($message, $recipient);
        return back()->with('success','Order Status Updated Successfully');
    }

    public function updateStatusCanceled(Request $request)
    {
        $this->validate($request,[
            'order_id' => 'required'
        ]);

        $order_id = $request->input('order_id');
        $order = Order::find($order_id);
        $order->status = 'canceled';
        $order->save();

        $message = 'Hello, '. $order->first_name .' '. $order->middle_initial .'. '. $order->last_name . '. Your Order with Order ID # '.$order->id.' has been cancelled.';
        $recipient = $order->email;

        $this->orderUpdateEmail($message, $recipient);

        return back()->with('success','Order Status Updated Successfully');
    }

    //Ajax Call
    public function loadOrderDetails(Request $request)
    {
        $order_id = $request->input('order_id');
        $orders = Order::find($order_id);
        $orderItems = $orders->orderItems;

        $html= 
        '
            <table class="table table-striped">
                <thead>
                    <tr class="text-center">
                        <th>Image</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
        ';
                
        foreach($orderItems as $orderItem)
        {
            $html.='
                    <tr class="text-center">
                        <td id="product_image" >
                            <figure><img style="height: 40px; width: 40px;" src="/storage/product_image/'.$orderItem->product->product_image.'" alt="" class="productimg img-responsive" id="previous_product_image"></figure> 
                        </td>
                        <td id="product_name">'.$orderItem->product->product_name.'</td>
                        <td id="product_quantity">'.$orderItem->quantity.'</td>
                        <td id="product_price"> ₱ '.number_format($orderItem->product->product_price, 2).'</td>
                    </tr>
                    ';
        }

        $html.='
                    </tbody>
                </table>
                ';

        $data = array
        (
            'orders' =>  $orders,
            'html' =>  $html
        );

        return response()->json($data);

    }

    

}
