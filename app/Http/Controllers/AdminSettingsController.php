<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class AdminSettingsController extends Controller
{
    //

    public function showAdminSettings()
    {   
        $admin_accounts = User::where('user_type', '=', 'admin')
                                ->orderBy('id','asc')->get();
        $admin_accounts_count = User::where('user_type', '=', 'admin')
                                ->count();
        $data = array
        (
            'admin_accounts' => $admin_accounts,
            'admin_accounts_count' => $admin_accounts_count,
            'title' => 'Administrator Settings'

        );
        return view('admin.settings')->with($data); 
    }

    public function addAdminAccount(Request $request)
    {
        $this->validate($request,[
            'email' => ['required', 'string', 'email', 'unique:users'],
            'admin_password' => ['required', 'string', 'min:8'],
            'admin_confirm_password' => 'required',
            'admin_first_name' => 'required',
            'admin_last_name' => 'required',
            'admin_middle_initial' => 'required',
            'admin_sex' => 'required',
            'admin_mobile' => 'required'
        ]);
    
        $admin = new User();
        $admin->email = $request->input('email');
        $admin->password = Hash::make($request->input('admin_password'));
        $admin->first_name = $request->input('admin_first_name');
        $admin->last_name = $request->input('admin_last_name');
        $admin->middle_initial = $request->input('admin_middle_initial');
        $admin->sex = $request->input('admin_sex');
        $admin->mobile = $request->input('admin_mobile');
        $admin->user_type = 'admin';

        $admin->save();

        return back()->with('success','Admin Account Added Successfully');
    }

    public function deleteAdminAcount(Request $request)
    {
        $this->validate($request,[
            'delete_admin_id' => 'required',
            'delete_admin_password' => 'required',
            'delete_admin_confirm_password' => 'required'
        ]);

        $admin_id = $request->input('delete_admin_id');
        $admin = User::find($admin_id);

        $current_admin_id = auth()->user()->id;
        $current_admin = User::find($current_admin_id);

        $current_password = $current_admin->password;
        $input_password = $request->input('delete_admin_password');


        if( $request->input('delete_admin_password') !=  $request->input('delete_admin_confirm_password'))
        {
            return back()->with('error','Password and Confirm Password Field Do Not Match');
        }
        else
        {
            if(Hash::check($input_password, $current_password))
            {
                $admin->delete();
                
                return back()->with('success','Admin Account Deleted Successfully');
            }
            else
            {
                return back()->with('error', 'Provided Password Incorrect');
                
            }
        }
    }

    public function deleteAllUserAccounts(Request $request)
    {
        $this->validate($request,[
            'delete_all_accounts_password' => 'required',
            'delete_all_accounts_confirm_password' => 'required'
        ]);

        $current_admin_id = auth()->user()->id;
        $current_admin = User::find($current_admin_id);
        $current_password = $current_admin->password;

        $input_password = $request->input('delete_all_accounts_password');


        if( $request->input('delete_all_accounts_password') !=  $request->input('delete_all_accounts_confirm_password'))
        {
            return back()->with('error','Password and Confirm Password Field Do Not Match');
        }
        else
        {
            if(Hash::check($input_password, $current_password))
            {
                User::where('user_type', '=', 'user')->delete();
                DB::table('shoppingcart')->delete();
                return back()->with('success','All User Accounts Deleted Successfully');
            }
            else
            {
                return back()->with('error', 'Provided Password Incorrect');
                
            }
        }
    }

    public function deleteAllItemInventory(Request $request)
    {
        $this->validate($request,[
            'delete_all_item_inventory_password' => 'required',
            'delete_all_item_inventory_confirm_password' => 'required'
        ]);

        $current_admin_id = auth()->user()->id;
        $current_admin = User::find($current_admin_id);
        $current_password = $current_admin->password;

        $input_password = $request->input('delete_all_item_inventory_password');


        if( $request->input('delete_all_item_inventory_password') !=  $request->input('delete_all_item_inventory_confirm_password'))
        {
            return back()->with('error','Password and Confirm Password Field Do Not Match');
        }
        else
        {
            if(Hash::check($input_password, $current_password))
            {
                Product::query()->delete();
                ProductCategory::query()->delete();

                $path = 'public/product_image/';
                $path_hd = 'public/product_image_hd/';

                $files =   Storage::allFiles($path);
                $files_hd =   Storage::allFiles($path_hd);
                Storage::delete($files);
                Storage::delete($files_hd);
                DB::table('shoppingcart')->delete();
                return back()->with('success','All Product Records Deleted Successfully');
            }
            else
            {
                return back()->with('error', 'Provided Password Incorrect');
                
            }
        }
    }

    public function deleteAllOrderAndDelivery(Request $request)
    {
        $this->validate($request,[
            'delete_all_order_delivery_password' => 'required',
            'delete_all_order_delivery_confirm_password' => 'required'
        ]);

        $current_admin_id = auth()->user()->id;
        $current_admin = User::find($current_admin_id);
        $current_password = $current_admin->password;

        $input_password = $request->input('delete_all_order_delivery_password');


        if( $request->input('delete_all_order_delivery_password') !=  $request->input('delete_all_order_delivery_confirm_password'))
        {
            return back()->with('error','Password and Confirm Password Field Do Not Match');
        }
        else
        {
            if(Hash::check($input_password, $current_password))
            {
                Order::query()->delete();
                return back()->with('success','All Order and Delivery Records Deleted Successfully');
            }
            else
            {
                return back()->with('error', 'Provided Password Incorrect');
                
            }
        }
    }

    public function deleteAllRecords(Request $request)
    {
        $this->validate($request,[
            'delete_all_records_password' => 'required',
            'delete_all_records_confirm_password' => 'required'
        ]);

        $current_admin_id = auth()->user()->id;
        $current_admin = User::find($current_admin_id);
        $current_password = $current_admin->password;

        $input_password = $request->input('delete_all_records_password');


        if( $request->input('delete_all_records_password') !=  $request->input('delete_all_records_confirm_password'))
        {
            return back()->with('error','Password and Confirm Password Field Do Not Match');
        }
        else
        {
            if(Hash::check($input_password, $current_password))
            {
                User::where('user_type', '=', 'user')->delete();

                Product::query()->delete();
                $path = 'public/product_image/';
                $path_hd = 'public/product_image_hd/';
                $files =   Storage::allFiles($path);
                $files_hd =   Storage::allFiles($path_hd);
                Storage::delete($files);
                Storage::delete($files_hd);

                ProductCategory::query()->delete();
                Order::query()->delete();
                OrderItem::query()->delete();
                DB::table('shoppingcart')->delete();
                
                return back()->with('success','All Store Records Deleted Successfully');
            }
            else
            {
                return back()->with('error', 'Provided Password Incorrect');
                
            }
        }
    }

    public function updateInfo(Request $request, User $user)
    {
        $this->validate($request,[
            'edit_admin_email' => 'required|email',
            'edit_admin_mobile' => 'required',
            'edit_admin_sex' => 'required',
            'edit_admin_first_name' => 'required',
            'edit_admin_last_name' => 'required',
            'edit_admin_middle_initial' => 'required',
            'admin_id' => 'required'
        ]);

        $admin_id = $request->input('admin_id');
        $admin = User::find($admin_id);

        $admin->first_name = $request->input('edit_admin_first_name');
        $admin->last_name = $request->input('edit_admin_last_name');
        $admin->middle_initial = $request->input('edit_admin_middle_initial');
        $admin->sex = $request->input('edit_admin_sex');
        $admin->mobile = $request->input('edit_admin_mobile');
        $admin->email = $request->input('edit_admin_email');

        $admin->save();

        return back()->with('success','Admin Account Updated Successfully');
    }

    public function changeAdminPassword(Request $request)
    {
        $this->validate($request,[
            'current_password' => 'required',
            'new_password' => ['required', 'string', 'min:8'],
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

    public function checkAdminEmail(Request $request)
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
