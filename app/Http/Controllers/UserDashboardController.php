<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserDashboardController extends Controller
{
    //
    public function showUserDashboard()
    {

        $current_user_id = auth()->user()->id;
        $user = User::find($current_user_id);

        $orders= Order::where('user_id', '=', $current_user_id)
                    ->orderBy('created_at','desc')->get()->take(3);
        $pending_orders= Order::where('user_id', '=', $current_user_id)
                                ->where('status', '=', 'ordered')->count();
        $shipped_orders= Order::where('user_id', '=', $current_user_id)
                                ->where('status', '=', 'shipped')->count();
        $delivered_orders= Order::where('user_id', '=', $current_user_id)
                                ->where('status', '=', 'delivered')->count();                                    
        $canceled_orders= Order::where('user_id', '=', $current_user_id)
                                ->where('status', '=', 'canceled')->count();  
        $data = array
        (
            'user' =>  $user,
            'orders' =>  $orders,
            'pending_orders' =>  $pending_orders,
            'shipped_orders' =>  $shipped_orders,
            'delivered_orders' =>  $delivered_orders,
            'canceled_orders' =>  $canceled_orders,
            'title' =>  'User Dashboard'
        );

        return view('user.dashboard')->with($data);

    }

    //Show Orders By Status

    public function showOrderAll()
    {
        $current_user_id = auth()->user()->id;
        $orders= Order::where('user_id', '=', $current_user_id)
                        ->orderBy('created_at','desc')->paginate(10);
        $data = array
        (
            'orders' =>  $orders,
            'title' =>  'My Orders'
        );
        return view('user.orderdelivery')->with($data);
    }

    public function showOrderOrdered()
    {
        $current_user_id = auth()->user()->id;
        $orders= Order::where('user_id', '=', $current_user_id)
                        ->where('status', '=', 'ordered')
                        ->orderBy('created_at','desc')->paginate(10);
        $data = array
        (
            'orders' =>  $orders,
            'title' =>  'My Orders'
        );
        return view('user.orderdelivery')->with($data);
    }

    public function showOrderShipped()
    {
        $current_user_id = auth()->user()->id;
        $orders= Order::where('user_id', '=', $current_user_id)
                        ->where('status', '=', 'shipped')
                        ->orderBy('created_at','desc')->paginate(10);
        $data = array
        (
            'orders' =>  $orders,
            'title' =>  'My Orders'
        );
        return view('user.orderdelivery')->with($data);
    }

    public function showOrderDelivered()
    {
        $current_user_id = auth()->user()->id;
        $orders= Order::where('user_id', '=', $current_user_id)
                        ->where('status', '=', 'delivered')
                        ->orderBy('created_at','desc')->paginate(10);
        $data = array
        (
            'orders' =>  $orders,
            'title' =>  'My Orders'
        );
        return view('user.orderdelivery')->with($data);
    }

    public function showOrderCanceled()
    {
        $current_user_id = auth()->user()->id;
        $orders= Order::where('user_id', '=', $current_user_id)
                        ->where('status', '=', 'canceled')
                        ->orderBy('created_at','desc')->paginate(10);
        $data = array
        (
            'orders' =>  $orders,
            'title' =>  'My Orders'
        );
        return view('user.orderdelivery')->with($data);
    }

    public function updateUserInfo(Request $request)
    {
        $this->validate($request,[
            'edit_user_id' => 'required',
            'edit_first_name' => 'required',
            'edit_last_name' => 'required',
            'edit_middle_initial' => 'required',
            'edit_sex' => 'required',
            'edit_mobile' => 'required',
            'edit_email' => 'required|email',
            'edit_city' => 'required',
            'edit_barangay' => 'required',
            'edit_barangay_code' => 'required',
            'edit_address_notes' => 'nullable',
            'edit_membership_code' => 'nullable',
        ]);

        $user_id = $request->input('edit_user_id');
        $user = User::find($user_id);

        $user->first_name = $request->input('edit_first_name');
        $user->last_name = $request->input('edit_last_name');
        $user->middle_initial = $request->input('edit_middle_initial');
        $user->sex = $request->input('edit_sex');
        $user->mobile = $request->input('edit_mobile');
        $user->email = $request->input('edit_email');
        $user->city = $request->input('edit_city');
        $user->barangay = $request->input('edit_barangay');
        $user->barangay_code = $request->input('edit_barangay_code');
        $user->address_notes = $request->input('edit_address_notes');
        $user->membership_code = $request->input('edit_membership_code');
        $user->save();

        return back()->with('success','Account Updated Successfully');
    }

    public function userDashboardCheckEmailAndMobile(Request $request)
    {
        $email  = $request->input('email');
        $mobile  = $request->input('mobile');
        $membership_code  = $request->input('membership_code');
        $emailExists = false;
        $mobileExists = false;

        if (User::where('email', '=', $email)->exists()) 
        {
            $emailExists = true;
        }
        else
        {
            $emailExists = false;
        }
        
        if (User::where('mobile', '=', $mobile)->exists()) 
        {
            $mobileExists = true;
        }
        else
        {
            $mobileExists = false;
        }

        if (User::where('membership_code', '=', $membership_code)->exists()) 
        {
            $membership_codeExists = true;
        }
        else
        {
            $membership_codeExists = false;
        }
        
        if($membership_code == '')
        {
            $membership_codeExists = false;
        }

        $data = array
        (
            'emailExists' =>  $emailExists,
            'mobileExists' =>  $mobileExists,
            'membership_codeExists' =>  $membership_codeExists
        );

        return $data;

    }

    //Account Settings

    public function showAccountSettings()
    {
        $current_user_id = auth()->user()->id;
        $user = User::find($current_user_id);

        $orders= Order::where('user_id', '=', $current_user_id)
                    ->orderBy('created_at','desc')->get()->take(3);
        $pending_orders= Order::where('user_id', '=', $current_user_id)
                                ->where('status', '=', 'ordered')->count();
        $shipped_orders= Order::where('user_id', '=', $current_user_id)
                                ->where('status', '=', 'shipped')->count();
        $delivered_orders= Order::where('user_id', '=', $current_user_id)
                                ->where('status', '=', 'delivered')->count();                                    
        $canceled_orders= Order::where('user_id', '=', $current_user_id)
                                ->where('status', '=', 'canceled')->count();  
        $data = array
        (
            'user' =>  $user,
            'orders' =>  $orders,
            'pending_orders' =>  $pending_orders,
            'shipped_orders' =>  $shipped_orders,
            'delivered_orders' =>  $delivered_orders,
            'canceled_orders' =>  $canceled_orders,
            'title' =>  'Account Settings'
        );

        return view('user.accountsettings')->with($data);

    }

    public function changeUserPassword(Request $request)
    {
        $this->validate($request,[
            'current_password' => 'required',
            'new_password' => 'required',
            'confirm_new_password' => 'required'
        ]);

        $current_user_id = auth()->user()->id;
        $user = User::find($current_user_id);
        $previous_password = $user->password;


        $current_password = $request->input('current_password');
        $new_password = $request->input('new_password');
        $confirm_new_password = $request->input('confirm_new_password');

        if($new_password != $confirm_new_password)
        {
            return back()->with('error','Password and Confirm Password Field Do Not Match');
        }
        else
        {
            if(Hash::check($current_password, $previous_password))
            {
                $user->password = Hash::make($new_password);
                $user->save();
                return back()->with('success','Password Changed Successfully');
            }
            else
            {
                return back()->with('error','Current Password Incorrect');
            }
        }
    }

}
