<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    public function deleteUser(Request $request)
    {
        $this->validate($request,[
            'delete_user_id' => 'required',
            'delete_user_name' => 'required'
        ]);
        $user_id = $request->input('delete_user_id');
        $user = User::find($user_id);
        $user->delete();
        
        return back()->with('success','User Deleted Successfully');
    }

    public function loadUserDetails(Request $request)
    {
        $user_id = $request->input('user_id');
        $user = User::find($user_id);
        $order_count = Order::where('user_id', '=', $user_id)
                        ->count();

        $data = array
        (
            'user' =>  $user,
            'order_count' =>  $order_count,
        );

        return response()->json($data);

    }

    public function editUserInfo(Request $request)
    {
        $this->validate($request,[
            'user_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_initial' => 'required',
            'sex' => 'required',
            'mobile' => 'required',
            'email' => 'email|required', 
            'city' => 'required',
            'barangay' => 'required',
            'barangay_code' => 'required',
            'address_notes' => 'nullable',
            'membership_code' => 'nullable'
        ]);

        $user_id = $request->input('user_id');
        $user = User::find($user_id);

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->middle_initial = $request->input('middle_initial');
        $user->sex = $request->input('sex');
        $user->mobile = $request->input('mobile');
        $user->email = $request->input('email');
        $user->city = $request->input('city');
        $user->barangay = $request->input('barangay');
        $user->barangay_code = $request->input('barangay_code');
        $user->address_notes = $request->input('address_notes');
        $user->membership_code = $request->input('membership_code');
        $user->save();

        return back()->with('success','User Updated Successfully');
    }

    public function checkUserEmail(Request $request)
    {
        $email  = $request->input('email');

        if (User::where('email', '=', $email)->exists()) 
        {
            return true;
        }
        else
        {
            return false;
        }

    }
}
