@extends('layouts.adminApp')

@section('scripts')
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">

@endsection

@section('styles')

    <style>

		/* Hiding and Showing Fields when Updating Data */
		.user_fields{
			display: none;
		}

		.user_info{
			
		}

        /* Admin Table  */
        .admin_table tbody tr td{
            vertical-align: middle;
        }

        .icon-bg{
            background-color: #4b922d;
            border: none;
        }

        .pw-icon{
            color: #ffffff
        }

        .prompt-heading{
            font-family: 'Montserrat',  sans-serif ;
            font-size: 18px;
            font-weight: 500;
            color: #000000;
        }

    </style>

@endsection

@section('content')

    {{-- Breadcrumbs --}}
    <div class="row breadcrumbs_row">
        <div class="col-md-6 col-12 align-self-center breadcrumb_col">
            <h3 class="text-themecolor mb-0">Administrator Settings</h3>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                <a href="/admin/dashboard">Administrator</a>
                </li>
                <li class="breadcrumb-item active">Settings</li>
            </ol>
        </div>

        <div class="col-md-6 col-12">
            <div class="row">
                <div class="col my-auto pr-0">
                    <span class="value card-number-text text-right">
                        @if (!empty($admin_accounts_count)){{$admin_accounts_count}}
                        @else 0
                        @endif
                    </span>
                </div>
                <div class="col my-auto">
                    <i class="fas fa-clipboard-list fa-3x icon text-left"></i>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-12">
                    <span class="label body-text"> Administrator Account(s)</span> 
                </div>
            </div>
        </div>
    </div>		

    {{-- Admin Acc Table --}}
    <div class="row">
        <div class="col-md-12 order-3 order-sm-3 order-md-3 order-lg-3">
            <div class="row gutters-sm">
                <div class="col-sm-12 col-md-12 col-12 mb-3">
                    <div class="card h-100">
                        <div class="card-body">

                            <div class="row mb-3">
                                <div class="col" >
                                    <i style="vertical-align: middle;" class="fas fa-user-cog fa-2x icon my-auto" aria-hidden="true"></i> <span class="card-title">Administrator Accounts</span> 
                                </div>
                            </div>
                            
                            {{-- Add Admin Account--}}
                            <hr>
                            <div class="row">
                                <div class="col-6 my-auto">
                                    <h6 class="body-text-thick">Add New Admin Account</h6>
                                </div>
                                <div class="col-6 my-auto text-right" >
                                    <a href="#add-admin-modal" data-toggle="modal">
                                        <button id="" type="button" class="btn page-btn body-text">
                                            <i class="fas fa-plus"></i> Add New Account
                                        </button>
                                    </a>
                                </div>
                            </div>

                            {{-- Admin Accounts Table --}}
                            <div class="row body-text">
                                <div class="col">
                                    <div class="table-responsive text-center " id="admin_table">
                                        <table id="admin_table_sort" class="table table-striped admin_table mt-2 display">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Admin ID</th>
                                                    <th>Email</th>
                                                    <th>Action</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center">
                                                @foreach ($admin_accounts as $admin_account)
                                                    
                                                    <tr>
                                                        <td>{{$admin_account->id}}</td>
                                                        <td>{{$admin_account->email}}</td>
                                                        <td>
                                                                <a class="" href="#admin-details-modal" data-toggle="modal" data-admin_id="{{$admin_account->id}}" >
                                                                    <button type="button" class="btn page-btn">
                                                                        Details
                                                                    </button>
                                                                </a>
                                                        </td>
                                                        <td>
                                                            @if (auth()->user()->id == $admin_account->id)
                                                                In Use
                                                            @else
                                                                <a class="" href="#delete-admin-modal" data-toggle="modal" data-admin_id="{{$admin_account->id}}" >
                                                                    <button type="button" class="btn page-btn">
                                                                        <span> <i class="fas fa-trash-alt"></i></span>
                                                                    </button>
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Admin Settings Field --}}
    <div class="row">
        <div class="col-md-12 order-3 order-sm-3 order-md-3 order-lg-3">
            <div class="row gutters-sm">
                <div class="col-sm-12 col-md-12 col-12 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col" >
                                    <i style="vertical-align: middle;" class="fas fa-user-cog fa-2x icon my-auto" aria-hidden="true"></i> <span class="card-title"> Administrator Settings</span>
                                </div>
                            </div>

                            {{-- Admin Change Password --}}
                            <hr>
                            {!! Form::open(['route' => 'admin.changeAdminPassword', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'edit_admin_password_form']) !!}
                                
                                <div class="row justify-content-between">
                                    <div class="col-sm-6 my-auto user_info">
                                        <h6 class="body-text-thick">Update Admin Account Password</h6>
                                    </div>
                                    <div class="col-sm-3 my-auto text-right">
                                        <button id="toggle_edit_btn" type="button" class="btn page-btn w-100">
                                            Change Password
                                        </button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4 col-sm-4 pb-2 my-auto user_fields">
                                        <h6 class="body-text-thick">Current Admin Password</h6>
                                    </div>
                                    <div class="col-8 col-sm-8 pb-2 text-secondary user_fields float-right">
                                        {{Form::password('current_password', ['class' => 'form-control body-text mb-0', 'placeholder' => 'Current Admin Password', 'required' => 'required', 'id' => 'current_password']) }}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4 col-sm-4 pb-2 my-auto user_fields">
                                        <h6 class="body-text-thick">New Admin Password</h6>
                                    </div>
                                    <div class="col-8 col-sm-8 pb-2 text-secondary user_fields">
                                        {{Form::password('new_password',  ['class' => 'form-control body-text mb-0', 'placeholder' => 'New Admin Password', 'required' => 'required', 'id' => 'new_password']) }}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4 col-sm-4 pb-2 my-auto user_fields">
                                        <h6 class="body-text-thick">Confirm New Admin Password</h6>
                                    </div>
                                    <div class="col-8 col-sm-8 pb-2 text-secondary user_fields">
                                        {{Form::password('confirm_new_password', ['class' => 'form-control body-text mb-0', 'placeholder' => 'Confirm New Admin Password', 'required' => 'required', 'id' => 'confirm_new_password']) }}
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-12 col-12 text-right user_fields">
                                        <div class="d-flex justify-content-end">
                                            <button id="save_changes_btn" type="submit" class="btn page-btn body-text">
                                                Change Password
                                            </button>
                                            <button id="cancel_btn" type="button" class="btn page-btn ml-2 body-text">
                                                Cancel
                                            </button>
                                        </div>
                                        
                                    </div>
                                </div>
                                

                                {{Form::hidden('_method', 'PUT')}}
                            {!! Form::close() !!}
                                
                            {{-- Reset Account Records --}}
                            <hr>
                            <div class="row justify-content-between">
                                <div class="col-sm-6 my-auto">
                                    <h6 class="body-text-thick">Delete All Account Records</h6>
                                </div>
                                <div class="col-sm-3 my-auto text-right">
                                    <button id="" type="button" class="btn page-btn w-100 body-text" href="#delete-account-modal" data-toggle="modal">
                                        Reset Accounts
                                    </button>
                                </div>
                            </div>
                                
                            {{-- Reset Item Inventory Records --}}
                            <hr>
                            <div class="row justify-content-between">
                                <div class="col-sm-6 my-auto">
                                    <h6 class="body-text-thick">Delete All Item Inventory Records</h6>
                                </div>
                                <div class="col-sm-3 my-auto text-right">
                                    <button id="" type="button" class="btn page-btn w-100 body-text" href="#delete-item-inventory-modal" data-toggle="modal">
                                        Reset Item Inventory
                                    </button>
                                </div>
                            </div>
                                
                            {{-- Reset Order and Delivery Records --}}
                            <hr>
                            <div class="row justify-content-between">
                                <div class="col-sm-6 my-auto">
                                    <h6 class="body-text-thick">Delete All Order and Delivery Records</h6>
                                </div>
                                <div class="col-sm-3 my-auto text-right">
                                    <button id="" type="button" class="btn page-btn w-100 body-text" href="#delete-order-delivery-modal" data-toggle="modal">
                                        Reset Order and Delivery
                                    </button>
                                </div>
                            </div>
                            
                            {{-- Reset All Account, Inventory, Order and Delivery --}}
                            <hr>
                            <div class="row justify-content-between">
                                <div class="col-sm-6 my-auto">
                                    <h6 class="body-text-thick">Delete All Records (Account, Item Inventory, Order and Delivery)</h6>
                                </div>
                                <div class="col-sm-4 my-auto text-right">
                                    <button id="" type="button" class="btn page-btn body-text"  href="#delete-all-records-modal" data-toggle="modal">
                                        Reset All
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

	
    {{-- Modals --}}

    {{-- Markup for Add Admin Account Modal --}}
    <div class="modal fade" id="add-admin-modal" tabindex="-1" role="dialog" aria-labelledby="add-admin-modal" aria-hidden="true">
                    
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title add-admin-heading" id="add-admin-heading">Add Admin Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    {!! Form::open(['route' => 'admin.addAdminAccount', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        @csrf

                        <div class="row"  id="admin_email_check" >     
                        </div>

                        <div class="form-row justify-content-center">
                            <div class="col-md-6 form-group">
                                {{Form::label('email', 'Email',['class' => 'body-text-thick'])}}
                                {{Form::email('email', '', ['class' => 'form-control body-text', 'placeholder' => 'Email', 'required' => 'required', 'id' => 'email' ]) }}
                            </div>
                            <div class="col-md-3 form-group">
                                {{Form::label('admin_password', 'Password',['class' => 'body-text-thick'])}}
                                {{Form::password('admin_password',  ['class' => 'form-control body-text', 'placeholder' => 'Password', 'required' => 'required', 'id' => 'admin_password' ]) }}
                            </div>
                            <div class="col-md-3 form-group">
                                {{Form::label('admin_confirm_password', 'Confirm Password',['class' => 'body-text-thick'])}}
                                {{Form::password('admin_confirm_password',  ['class' => 'form-control body-text', 'placeholder' => 'Confirm Password', 'required' => 'required', 'id' => 'admin_confirm_password' ]) }}
                            </div>
                            
                        </div>

                        <div class="form-row justify-content-center">
                            <div class="col-md-4 form-group">
                                {{Form::label('admin_first_name', 'First Name',['class' => 'body-text-thick'])}}
                                {{Form::text('admin_first_name', '', ['class' => 'form-control body-text', 'placeholder' => 'First Name', 'required' => 'required', 'id' => 'admin_first_name' ]) }}
                            </div>
                            <div class="col-md-4 form-group">
                                {{Form::label('admin_last_name', 'Last Name',['class' => 'body-text-thick'])}}
                                {{Form::text('admin_last_name', '', ['class' => 'form-control body-text', 'placeholder' => 'Last Name', 'required' => 'required', 'id' => 'admin_last_name' ]) }}
                            </div>
                            <div class="col-md-4 form-group">
                                {{Form::label('admin_middle_initial', 'Middle Initial',['class' => 'body-text-thick'])}}
                                {{Form::text('admin_middle_initial', '', ['class' => 'form-control body-text', 'placeholder' => 'Middle Initial', 'required' => 'required', 'id' => 'admin_middle_initial' ]) }}
                            </div>
                        </div>

                        <div class="form-row justify-content-center">
                            <div class="col-md-4 form-group">
                                {{Form::label('admin_sex', 'Sex', ['class' => 'user_details_label body-text-thick'])}}
                                {{Form::select('admin_sex', array('Male' => 'Male','Female' => 'Female') , null, array('class' => 'form-control body-text', 'id' => 'admin_sex' ));}}
                            </div>
                            
                            <div class="col-md-4 form-group">
                                {{Form::label('admin_mobile', 'Mobile Number',['class' => 'body-text-thick'])}}
                                {{Form::number('admin_mobile', '', ['class' => 'form-control body-text', 'placeholder' => 'Mobile Number', 'required' => 'required', 'id' => 'admin_mobile' ]) }}
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-xs-12 col-md-12 text-center">
                                {{Form::button('Add Account', array(
                                    'type' => 'submit',
                                    'class'=> 'btn page-btn body-text',
                                    'id' => 'add_admin_btn',
                                    )) 
                                }}
                                <button type="button" class="btn page-btn body-text" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                        
                    {!! Form::close() !!}
                </div>

            </div>
        </div>
    </div>

    {{-- Markup for Admin Details Modal --}}
    <div class="modal fade" id="admin-details-modal" tabindex="-1" role="dialog" aria-labelledby="admin-details-modal" aria-hidden="true">
                    
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title admin-details-heading" id="admin-details-heading"><span class="admin_name"></span>'s Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="row justify-content-end">
                        <div class="col-md-6 col-4">
                            <div class="float-right">
                                <button id="toggle_edit_admin_btn" type="button" class="btn page-btn">
                                    <span> <i class="fas fa-edit"></i></span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="edit_admin_check" class="">

                    </div>

                    {!! Form::open(['route' => 'admin.updateInfo', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'edit_admin_form']) !!}
                        @csrf
                        {{Form::hidden('admin_id', '', ['id' => 'admin_id']) }}

                        <div class="form-row justify-content-center">
                            <div class="col-md-6 form-group">
                                {{Form::label('edit_admin_email', 'Email', ['class' => 'body-text-thick'])}}
                                {{Form::email('edit_admin_email', '', ['class' => 'form-control body-text', 'placeholder' => 'Email', 'required' => 'required', 'readonly' => 'readonly', 'id' => 'edit_admin_email' ]) }}
                            </div>
                            <div class="col-md-4 form-group">
                                {{Form::label('edit_admin_mobile', 'Mobile Number', ['class' => 'body-text-thick'])}}
                                {{Form::number('edit_admin_mobile', '', ['class' => 'form-control body-text', 'placeholder' => 'Mobile Number', 'required' => 'required', 'readonly' => 'readonly', 'id' => 'edit_admin_mobile' ]) }}
                            </div>
                            <div class="col-md-2 form-group">
                                {{Form::label('edit_admin_sex', 'Sex', ['class' => 'user_details_label body-text-thick'])}}
                                {{Form::select('edit_admin_sex', array('Male' => 'Male','Female' => 'Female') , null, array('class' => 'form-control body-text', 'disabled' => 'disabled', 'id' => 'edit_admin_sex' ));}}
                            </div>
                        </div>

                        <div class="form-row justify-content-center">
                            <div class="col-md-4 form-group">
                                {{Form::label('edit_admin_first_name', 'First Name', ['class' => 'body-text-thick'])}}
                                {{Form::text('edit_admin_first_name', '', ['class' => 'form-control body-text', 'placeholder' => 'First Name', 'required' => 'required', 'readonly' => 'readonly', 'id' => 'edit_admin_first_name' ]) }}
                            </div>
                            <div class="col-md-4 form-group">
                                {{Form::label('edit_admin_last_name', 'Last Name', ['class' => 'body-text-thick'])}}
                                {{Form::text('edit_admin_last_name', '', ['class' => 'form-control body-text', 'placeholder' => 'Last Name', 'required' => 'required', 'readonly' => 'readonly', 'id' => 'edit_admin_last_name' ]) }}
                            </div>
                            <div class="col-md-4 form-group">
                                {{Form::label('edit_admin_middle_initial', 'Middle Initial', ['class' => 'body-text-thick'])}}
                                {{Form::text('edit_admin_middle_initial', '', ['class' => 'form-control body-text', 'placeholder' => 'Middle Initial', 'required' => 'required', 'readonly' => 'readonly', 'id' => 'edit_admin_middle_initial' ]) }}
                            </div>
                        </div>

                        <div style="display: none;" class="form-row pt-2" id="submit_div">
                            <div class="col-xs-12 col-md-12 text-center">
                                {{Form::button('Edit Admin Info', array(
                                    'type' => 'submit',
                                    'class'=> 'btn page-btn body-text',
                                    'id' => 'edit_admin_btn',
                                    )) 
                                }}
                                <button type="button" class="btn page-btn body-text" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                        
                        {{Form::hidden('_method', 'PUT')}}
                    {!! Form::close() !!}
                            
                </div>

            </div>
        </div>
    </div>

    {{-- Markup for Delete Account Records --}}
    <div class="modal fade" id="delete-account-modal" tabindex="-1" role="dialog" aria-labelledby="delete-account-modal" aria-hidden="true">
            
        <div class="modal-dialog modal-md" role="document">

            <div class="modal-content">

                <div class="modal-header pb-2 mb-3">
                    <h5 class="modal-title delete-account-heading" id="delete-account-heading">Delete All Account Records</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['route' => 'admin.deleteAllUserAccounts', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    <div class="modal-body">
                        @csrf
                        
                        <h5 class="delete-account-prompt prompt-heading text-center">This Action Will Delete All Accounts in the System</h5>

                        <hr>

                        <div class="form-row justify-content-center">
                            <h5 class="delete-account-prompt  body-text-thick text-center pb-2"> Type Your Password to Continue</h5>
                            <div class="col-md-8 form-group text-center">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text icon-bg btn"><i class="fas fa-key pw-icon "> </i> </span>
                                    </div>
                                    {{Form::password('delete_all_accounts_password', ['class' => 'form-control body-text text-center', 'placeholder' => 'Password', 'required' => 'required',  'id'=>'delete_all_accounts_password' ]) }}
                                </div>
                            </div>
                        </div>

                        <div class="form-row justify-content-center">
                            <div class="col-md-8 form-group text-center">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text icon-bg"><i class="fas fa-key pw-icon"> </i> </span>
                                    </div>
                                    {{Form::password('delete_all_accounts_confirm_password', ['class' => 'form-control body-text text-center', 'placeholder' => 'Confirm Password', 'required' => 'required', 'id'=>'delete_all_accounts_confirm_password' ]) }}
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <div class="form-row mx-auto">
                            <div class="col-xs-12 col-md-12 ">
                                {{Form::hidden('_method', 'DELETE')}}
                                {{Form::button('Delete All Accounts', array('type' => 'submit','class'=> 'btn page-btn',)) 
                                }}
                                <button type="button" class="btn page-btn" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
                
                    
            </div>
        </div>
    </div>

    {{-- Markup for Delete Item Inventory Records --}}
    <div class="modal fade" id="delete-item-inventory-modal" tabindex="-1" role="dialog" aria-labelledby="delete-item-inventory-modal" aria-hidden="true">
            
        <div class="modal-dialog modal-md" role="document">

            <div class="modal-content">

                <div class="modal-header pb-2 mb-3">
                    <h5 class="modal-title delete-item-inventory-heading" id="delete-item-inventory-heading">Delete All Product Records</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['route' => 'admin.deleteAllItemInventory', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    <div class="modal-body">
                        @csrf
                        
                        <h5 class="delete-item-inventory-prompt  prompt-heading text-center">This Action Will Delete All Product and Product Category in the System</h5>

                        <hr>

                        <div class="form-row justify-content-center">
                            <h5 class="delete-item-inventory-prompt  body-text-thick text-center pb-2"> Type Your Password to Continue</h5>
                            <div class="col-md-8 form-group text-center">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text icon-bg"><i class="fas fa-key pw-icon"> </i> </span>
                                    </div>
                                    {{Form::password('delete_all_item_inventory_password', ['class' => 'form-control body-text text-center', 'placeholder' => 'Password', 'required' => 'required',  'id'=>'delete_all_item_inventory_password' ]) }}
                                </div>
                            </div>
                        </div>

                        <div class="form-row justify-content-center">
                            <div class="col-md-8 form-group text-center">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text icon-bg"><i class="fas fa-key pw-icon"> </i> </span>
                                    </div>
                                    {{Form::password('delete_all_item_inventory_confirm_password', ['class' => 'form-control body-text text-center', 'placeholder' => 'Confirm Password', 'required' => 'required', 'id'=>'delete_all_item_inventory_confirm_password' ]) }}
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <div class="form-row mx-auto">
                            <div class="col-xs-12 col-md-12 ">
                                {{Form::hidden('_method', 'DELETE')}}
                                {{Form::button('Delete All Products', array('type' => 'submit','class'=> 'btn page-btn',)) 
                                }}
                                <button type="button" class="btn page-btn" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
                
                    
            </div>
        </div>
    </div>

    {{-- Markup for Delete Order and Delivery Records --}}
    <div class="modal fade" id="delete-order-delivery-modal" tabindex="-1" role="dialog" aria-labelledby="delete-order-delivery-modal" aria-hidden="true">
        
        <div class="modal-dialog modal-md" role="document">

            <div class="modal-content">

                <div class="modal-header pb-2 mb-3">
                    <h5 class="modal-title delete-order-delivery-heading" id="delete-order-delivery-heading">Delete All Order and Delivery Records</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['route' => 'admin.deleteAllOrderAndDelivery', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    <div class="modal-body">
                        @csrf
                        
                        <h5 class="delete-order-delivery-prompt  prompt-heading text-center">This Action Will Delete All Order and Delivery in the System</h5>

                        <hr>

                        <div class="form-row justify-content-center">
                            <h5 class="delete-order-delivery-prompt  body-text-thick text-center pb-2"> Type Your Password to Continue</h5>
                            <div class="col-md-8 form-group text-center">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text icon-bg"><i class="fas fa-key pw-icon"> </i> </span>
                                    </div>
                                    {{Form::password('delete_all_order_delivery_password', ['class' => 'form-control body-text text-center', 'placeholder' => 'Password', 'required' => 'required',  'id'=>'delete_all_order_delivery_password' ]) }}
                                </div>
                            </div>
                        </div>

                        <div class="form-row justify-content-center">
                            <div class="col-md-8 form-group text-center">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text icon-bg"><i class="fas fa-key pw-icon"> </i> </span>
                                    </div>
                                    {{Form::password('delete_all_order_delivery_confirm_password', ['class' => 'form-control body-text text-center', 'placeholder' => 'Confirm Password', 'required' => 'required', 'id'=>'delete_all_order_delivery_confirm_password' ]) }}
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <div class="form-row mx-auto">
                            <div class="col-xs-12 col-md-12 ">
                                {{Form::hidden('_method', 'DELETE')}}
                                {{Form::button('Delete All Orders and Deliveries', array('type' => 'submit','class'=> 'btn page-btn',)) 
                                }}
                                <button type="button" class="btn page-btn" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
                
                    
            </div>
        </div>
    </div>

    {{-- Markup for Delete All Records --}}
    <div class="modal fade" id="delete-all-records-modal" tabindex="-1" role="dialog" aria-labelledby="delete-all-records-modal" aria-hidden="true">
    
        <div class="modal-dialog modal-md" role="document">

            <div class="modal-content">

                <div class="modal-header pb-2 mb-3">
                    <h5 class="modal-title delete-all-records-heading" id="delete-all-records-heading">Delete All Store Records</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['route' => 'admin.deleteAllRecords', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    <div class="modal-body">
                        @csrf
                        
                        <h5 class="delete-all-records-prompt  prompt-heading text-center">This Action Will Delete All Store Records (Accounts, Items, Orders and Deliveries) in the System</h5>

                        <hr>

                        <div class="form-row justify-content-center">
                            <h5 class="delete-all-records-prompt  body-text-thick text-center pb-2"> Type Your Password to Continue</h5>
                            <div class="col-md-8 form-group text-center">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text icon-bg"><i class="fas fa-key pw-icon"> </i> </span>
                                    </div>
                                    {{Form::password('delete_all_records_password', ['class' => 'form-control body-text text-center', 'placeholder' => 'Password', 'required' => 'required',  'id'=>'delete_all_records_password' ]) }}
                                </div>
                            </div>
                        </div>

                        <div class="form-row justify-content-center">
                            <div class="col-md-8 form-group text-center">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text icon-bg"><i class="fas fa-key pw-icon"> </i> </span>
                                    </div>
                                    {{Form::password('delete_all_records_confirm_password', ['class' => 'form-control body-text text-center', 'placeholder' => 'Confirm Password', 'required' => 'required', 'id'=>'delete_all_records_confirm_password' ]) }}
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <div class="form-row mx-auto">
                            <div class="col-xs-12 col-md-12 ">
                                {{Form::hidden('_method', 'DELETE')}}
                                {{Form::button('Delete All Store Records', array('type' => 'submit','class'=> 'btn page-btn',)) 
                                }}
                                <button type="button" class="btn page-btn" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
                
                    
            </div>
        </div>
    </div>

    {{-- Markup for Delete Admin Modal --}}
    <div class="modal fade" id="delete-admin-modal" tabindex="-1" role="dialog" aria-labelledby="delete-admin-modal" aria-hidden="true">
            
        <div class="modal-dialog modal-md" role="document">

            <div class="modal-content">

                <div class="modal-header pb-2 mb-3">
                    <h5 class="modal-title delete-admin-heading" id="delete-admin-heading">Delete Admin Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['route' => 'admin.deleteAdminAcount', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    <div class="modal-body">
                        {{Form::hidden('delete_admin_id', '',['id'=>'delete_admin_id'])}}
                        @csrf
                        
                        <h5 class="delete-admin-prompt  prompt-heading text-center">Are you sure you want to delete this Administrator Account?</h5>

                        <div class="form-row justify-content-center">                               

                            <div class="col-md-6 form-group text-center">
                                {{Form::label('delete_admin_name', 'Admin Name')}}
                                {{Form::text('delete_admin_name', '', ['class' => 'form-control body-text text-center', 'placeholder' => 'Admin Name', 'required' => 'required', 'readonly'=>'readonly',  'id'=>'delete_admin_name'  ]) }}
                            </div>
                            <div class="col-md-6 form-group text-center">
                                {{Form::label('delete_admin_email', 'Admin Email')}}
                                {{Form::text('delete_admin_email', '', ['class' => 'form-control body-text text-center', 'placeholder' => 'Admin Email', 'required' => 'required', 'readonly'=>'readonly',  'id'=>'delete_admin_email'  ]) }}
                            </div>
                        </div>

                        <hr>

                        <div class="form-row justify-content-center">
                            <h5 class="delete-admin-prompt  body-text-thick text-center pb-2">Please type your password to confirm</h5>
                            <div class="col-md-8 form-group text-center">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text icon-bg"><i class="fas fa-key pw-icon"> </i> </span>
                                    </div>
                                    {{Form::password('delete_admin_password', ['class' => 'form-control body-text text-center', 'placeholder' => 'Password', 'required' => 'required',  'id'=>'delete_admin_password' ]) }}
                                </div>
                            </div>
                        </div>

                        <div class="form-row justify-content-center">
                            <div class="col-md-8 form-group text-center">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text icon-bg"><i class="fas fa-key pw-icon"> </i> </span>
                                    </div>
                                    {{Form::password('delete_admin_confirm_password', ['class' => 'form-control body-text text-center', 'placeholder' => 'Confirm Password', 'required' => 'required', 'id'=>'delete_admin_confirm_password' ]) }}
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <div class="form-row mx-auto">
                            <div class="col-xs-12 col-md-12 ">
                                {{Form::hidden('_method', 'DELETE')}}
                                {{Form::button('Delete', array('type' => 'submit','class'=> 'btn page-btn',)) 
                                }}
                                <button type="button" class="btn page-btn" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
                
                    
            </div>
        </div>
    </div>

@endsection

@section('post-scripts')

    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js" defer></script>

    <script>
        function setup_ajax()
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }
        
  		function toggleEdit(){
            $('#toggle_edit_btn').click(function(){
                $(".user_fields").toggle();
                $(".user_info").toggle();
                $("#toggle_edit_btn").hide();
            });

			$('#cancel_btn').click(function(){
                $(".user_fields").toggle();
                $(".user_info").toggle();
                $("#toggle_edit_btn").show();
				reset_fields();
            });
        }

		function reset_fields()
        {
			$('#current_password').val('');
			$('#new_password').val('');
			$('#confirm_new_password').val('');
        }

        function disable_period()
        {
            $('#admin_middle_initial').keydown(function(e) {
                if (e.keyCode === 190 || e.keyCode === 110) {
                    e.preventDefault();
                }
            });
            $('#edit_admin_middle_initial').keydown(function(e) {
                if (e.keyCode === 190 || e.keyCode === 110) {
                    e.preventDefault();
                }
            });
        }

        function clear_modal()
        {

            $('#add-admin-modal').on('show.bs.modal', function (e) {
                $('#email').val('');
                $('#admin_password').val('');
                $('#admin_confirm_password').val('');
                $('#admin_first_name').val('');
                $('#admin_last_name').val('');
                $('#admin_middle_initial').val('');
                $('#admin_sex').val('');
                $('#admin_mobile').val('');
            });

            $('#add-admin-modal').on('hidden.bs.modal', function (e) {
                $('#email').val('');
                $('#admin_password').val('');
                $('#admin_confirm_password').val('');
                $('#admin_first_name').val('');
                $('#admin_last_name').val('');
                $('#admin_middle_initial').val('');
                $('#admin_sex').val('');
                $('#admin_mobile').val('');
            });

            $('#admin-details-modal').on('hidden.bs.modal', function (e) {
                $('#edit_admin_email').val('');
                $('#edit_admin_mobile').val('');
                $('#edit_admin_sex').val('');
                $('#edit_admin_first_name').val('');
                $('#edit_admin_last_name').val('');
                $('#edit_admin_middle_initial').val('');

                $('#edit_admin_email').prop('readonly', true);
                $('#edit_admin_mobile').prop('readonly', true);
                $('#edit_admin_sex').attr('disabled', true);
                $('#edit_admin_first_name').prop('readonly', true);
                $('#edit_admin_last_name').attr('readonly', true);
                $('#edit_admin_middle_initial').prop('readonly', true);
                $('#submit_div').hide();
                $("#edit_admin_check").html(``);

            });

            $('#delete-admin-modal').on('hidden.bs.modal', function (e) {
                $('#delete_admin_id').val('');
                $('#delete_admin_name').val('');
                $('#delete_admin_email').val('');
                $('#delete_admin_password').val('');
                $('#delete_admin_confirm_password').val('');

            });

            $('#delete-account-modal').on('hidden.bs.modal', function (e) {
                $('#delete_all_accounts_password').val('');
                $('#delete_all_accounts_confirm_password').val('');
            });

            $('#delete-item-inventory-modal').on('hidden.bs.modal', function (e) {
                $('#delete_all_item_inventory_password').val('');
                $('#delete_all_item_inventory_confirm_password').val('');
            });

            $('#delete-order-delivery-modal').on('hidden.bs.modal', function (e) {
                $('#delete_all_order_delivery_password').val('');
                $('#delete_all_order_delivery_confirm_password').val('');
            });

            $('#delete-all-records-modal').on('hidden.bs.modal', function (e) {
                $('#delete_all_order_delivery_password').val('');
                $('#delete_all_order_delivery_confirm_password').val('');
            });

            

        }

        function check_email()
        {
            setup_ajax();

            $('#email').keyup(function()
            {
                var email = $(this).val();
                if(email != '')
                {
                    $.ajax({
                        url: '/checkAdminEmail',
                        type: 'post',
                        data: {email: email},
                        success: function(data)
                        { 
                            if(data == true)
                            {
                                $("#admin_email_check").html 
                                (
                                    `<div style="text-align:center" class = "alert alert-danger alert-dismissible fade show col-md-6 offset-md-3" role="alert">
                                        Email Already in Use
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>                               
                                    </div>`
                                );
                                document.getElementById("add_admin_btn").disabled = true;
                            }
                            else
                            {
                                $("#admin_email_check").html( ``);
                                document.getElementById("add_admin_btn").disabled = false;
                            }
                        },
                        error:function(data)
                        {
                            errormsg = JSON.stringify(data);
                            console.log(errormsg);
                        }
                    });

                }
            });
        }

        function check_edit_email()
        {
            var current_email;

            $('#admin-details-modal').on('show.bs.modal', function (e) {

                var user_id = $(e.relatedTarget).data('admin_id');
                $.ajax({
                    type : 'post',
                    url : '/loadUserDetails',
                    
                    data : {user_id:user_id},
                    dataType: 'json',
                    success : function(data)
                    {
                        current_email = data.user.email;
                    },
                    error:function(data)
                    {
                        errormsg = JSON.stringify(data);
                        console.log(errormsg);
                    }
                });
            });

            $('#edit_admin_email').keyup(function()
            {
                var email = $(this).val();
                if(email != '')
                {
                    $.ajax({
                        url: '/checkAdminEmail',
                        type: 'post',
                        data: {email: email},
                        success: function(data)
                        { 
                            if(email == current_email && data == true)
                            {
                                $("#edit_admin_check").html( ``);
                                document.getElementById("edit_admin_btn").disabled = false;
                            }                        
                            else if(email != current_email && data == true)
                            {
                                $("#edit_admin_check").html 
                                (
                                    `<div style="text-align:center" class = "alert alert-danger alert-dismissible fade show col-md-6 offset-md-3" role="alert">
                                        Email Already in Use
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>                               
                                    </div>`
                                );
                                document.getElementById("edit_admin_btn").disabled = true;
                            }
                            else if(data == false)
                            {
                                $("#edit_admin_check").html( ``);
                                document.getElementById("edit_admin_btn").disabled = false;
                            }
                        },
                        error:function(data)
                        {
                            errormsg = JSON.stringify(data);
                            console.log(errormsg);
                        }
                    });

                }
            });
        }

        function toggleEditAdminDetails(){
            $('#toggle_edit_admin_btn').click(function(){
                if(
                    $('#edit_admin_email').prop('readonly') || $('#edit_admin_mobile').prop('readonly') || $('#edit_admin_sex').attr('disabled') 
                    || $('#edit_admin_first_name').prop('readonly') || $('#edit_admin_last_name').prop('readonly') || $('#edit_admin_middle_initial').prop('readonly')
                    )
                { 
                    $('#edit_admin_email').prop('readonly', false);
                    $('#edit_admin_mobile').prop('readonly', false);
                    $('#edit_admin_sex').attr('disabled', false);
                    $('#edit_admin_first_name').prop('readonly', false);
                    $('#edit_admin_last_name').prop('readonly', false);
                    $('#edit_admin_middle_initial').prop('readonly', false);
                    $('#submit_div').show();
                }
                else
                {
                    $('#edit_admin_email').prop('readonly', true);
                    $('#edit_admin_mobile').prop('readonly', true);
                    $('#edit_admin_sex').attr('disabled', true);
                    $('#edit_admin_first_name').prop('readonly', true);
                    $('#edit_admin_last_name').prop('readonly', true);
                    $('#edit_admin_middle_initial').prop('readonly', true);
                    $('#submit_div').hide();
                }
            });
        }

        function load_user_details()
        {
            $('#admin-details-modal').on('show.bs.modal', function (e) {

                setup_ajax();

                var user_id = $(e.relatedTarget).data('admin_id');
                $.ajax({
                    type : 'post',
                    url : '/loadUserDetails',
                    
                    data : {user_id:user_id},
                    dataType: 'json',
                    success : function(data)
                    {
                        
                        document.getElementById('admin_id').value = data.user.id;

                        document.getElementById('edit_admin_email').value = data.user.email;
                        document.getElementById('edit_admin_mobile').value = data.user.mobile;
                        document.getElementById('edit_admin_sex').value =  data.user.sex;

                        document.getElementById('edit_admin_first_name').value = data.user.first_name;
                        document.getElementById('edit_admin_last_name').value = data.user.last_name;
                        document.getElementById('edit_admin_middle_initial').value = data.user.middle_initial;
                        document.getElementsByClassName('admin_name')[0].innerHTML = (data.user.first_name+' '+data.user.middle_initial+'. '+ data.user.last_name);

                    },
                    error:function(data)
                    {
                        errormsg = JSON.stringify(data);
                        console.log(errormsg);
                    }
                });
            });

            $('#delete-admin-modal').on('show.bs.modal', function (e) {

                setup_ajax();

                var user_id = $(e.relatedTarget).data('admin_id');
                $.ajax({
                    type : 'post',
                    url : '/loadUserDetails',
                    
                    data : {user_id:user_id},
                    dataType: 'json',
                    success : function(data)
                    {
                        
                        document.getElementById('delete_admin_id').value = data.user.id;
                        document.getElementById('delete_admin_name').value = data.user.first_name+' '+data.user.middle_initial+'. '+ data.user.last_name;
                        document.getElementById('delete_admin_email').value = data.user.email;
                        
                    },
                    error:function(data)
                    {
                        errormsg = JSON.stringify(data);
                        console.log(errormsg);
                    }
                });
            });
        }

        //Registersw
        function register_sw()
        {
            navigator.serviceWorker.register('/sw.js');
        }

        //Show Notification
        function showNotification(message)
        {
            // const notification = new Notification ("Koop Hardware Online Store",
            // {
            //     icon: '/storage/logo/icon.png',
            //     body: message
            // });

            // notification.onclick = (e) => 
            // {
            //     window.location.href = "/admin/orders/ordered"
            // }
            
            
            navigator.serviceWorker.getRegistration().then( function( registration )
            {
                
                //Display Notification
                registration.showNotification
                ( 
                    "Koop Hardware Online Store",
                    {
                        icon: '/storage/logo/icon.png',
                        badge:'/storage/logo/icon.png',
                        body:message
                    } 
                );
            } );
            
            
        }

        //Ask for Notification Permissions
        function ask_notif_permission()
        {
            if(Notification.permission !== 'granted')
            {
                Notification.requestPermission();
            }
        }

        //Realtime Refresh and Notification in Admin Dashboard
        function realtime_notif()
		{
            
			var pusher = new Pusher('03527b096d7dc99cecc1', {
				cluster: 'ap1'
			});

			var channel = pusher.subscribe('admin-channel');
			channel.bind('order-placed-event', function(data) {
                
                //Desktop Push Notif
                if(Notification.permission == 'granted')
                {   
                    showNotification(data.message['text']);
                }

			});
		}

        $(document).ready(function(){

            register_sw();

            ask_notif_permission();
            realtime_notif();

            load_user_details();
            check_edit_email();
            toggleEditAdminDetails();
			toggleEdit();
            disable_period();
            check_email();
            clear_modal();
		});
    </script>

@endsection