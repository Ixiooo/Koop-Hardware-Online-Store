@extends('layouts.adminApp')

@section('scripts')
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">

@endsection

@section('styles')
    <style>

        .dataTables_length, .dataTables_filter{
            padding-top: 10px;
            padding-left: 5px;
            padding-right: 5px;
        }
        
        table.dataTable thead th {
            border-bottom: none;
        }

        .users_table{
            overflow-x: scroll;
        }
        
        .users_table thead tr th
        {
            text-align: center;
        }

        .users_table tbody tr td{
            text-align: center;
        }


    </style>
@endsection

@section('content')

    {{-- Breadcrumbs and Accounts Info--}}
    <div class="row breadcrumbs_row">
        <div class="col-md-6 col-12 align-self-center breadcrumb_col">
            <h3 class="text-themecolor mb-0">Account Management</h3>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                <a href="/admin/dashboard">Administrator</a>
                </li>
                <li class="breadcrumb-item active">Account Management</li>
            </ol>
        </div>

        {{-- Registered Accounts Col--}}
        <div class="col-md-6 col-12">
            <div class="row">
                <div class="col my-auto pr-0">
                    <span class="value card-number-text text-right">
                        @if (!empty($registered_accounts)){{$registered_accounts}}
                        @else 0
                        @endif
                    </span>
                </div>
                <div class="col my-auto">
                    <i class="fas fa-users fa-3x icon text-left"></i>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-12">
                    <span class="label body-text"> Registered Account(s)</span> 
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">

            {{-- User Table Markup --}}
            <div class="card ">
                <div class="card-body body-text">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <span class="card-heading"> Registered Users</span>
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>

                    <div class="table-responsive" id="users_table">
                        <table id="users_table_sort" class="table table-striped users_table mt-2 display">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Sex</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    
                                    <tr>
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->first_name.' '.$user->middle_initial.'. '.$user->last_name}}</td>
                                        <td>{{$user->barangay.',  '. $user->city. ' City. '. $user->address_notes}}</td>
                                        <td>{{$user->sex}}</td>
                                        <td>{{$user->mobile}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>
                                            <a class="" href="#user-details-modal" data-toggle="modal" data-user_id="{{$user->id}}" >
                                                <button type="button" class="btn page-btn">
                                                    Details
                                                </button>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="" href="#delete-user-modal" data-toggle="modal" data-user_id="{{$user->id}}" >
                                                <button type="button" class="btn page-btn">
                                                    <span> <i class="fas fa-trash-alt"></i></span>
                                                </button>
                                            </a>
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


    {{-- User Details Modal --}}

    {{-- Markup for User Details Modal --}}
    <div class="modal fade" id="user-details-modal" tabindex="-1" role="dialog" aria-labelledby="user-details-modal" aria-hidden="true">
                    
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title user-details-heading" id="user-details-heading">User Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                            <div class="row">
                                <div class="col-md-6 col-8 my-auto">
                                    <span class="user_name body-text-thick"></span>'s Details
                                </div>
                                <div class="col-md-6 col-4">
                                    <div class="float-right">
                                        <button id="toggle_edit_btn" type="button" class="btn page-btn">
                                            <span> <i class="fas fa-edit"></i></span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="edit_user_check" class="">

                            </div>
                            {!! Form::open(['route' => 'user.updateInfo', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'edit_user_form']) !!}
                                @csrf
        
                                <div class="form-row justify-content-center pt-2">
                                    {{Form::hidden('user_id', '', ['id' => 'user_id']) }}
                                    <div class="col-md-4 form-group">
                                        {{Form::label('first_name', 'First Name', ['class' => 'user_details_label body-text-thick'])}}
                                        {{Form::text('first_name', '', ['class' => 'form-control body-text', 'placeholder' => 'First Name', 'required' => 'required', 'id' => 'first_name', 'readonly' => 'readonly' ]) }}
                                    </div>
                                    <div class="col-md-4 form-group">
                                        {{Form::label('last_name', 'Last Name', ['class' => 'user_details_label body-text-thick'])}}
                                        {{Form::text('last_name', '', ['class' => 'form-control body-text', 'placeholder' => 'Last Name', 'required' => 'required', 'id' => 'last_name', 'readonly' => 'readonly' ]) }}
                                    </div>
                                    <div class="col-md-2 form-group">
                                        {{Form::label('middle_initial', 'Middle Initial', ['class' => 'user_details_label body-text-thick'])}}
                                        {{Form::text('middle_initial', '', ['class' => 'form-control body-text', 'placeholder' => 'Middle Initial', 'required' => 'required', 'id' => 'middle_initial', 'readonly' => 'readonly' ]) }}
                                    </div>
                                    <div class="col-md-2 form-group">
                                        {{Form::label('sex', 'Sex', ['class' => 'user_details_label body-text-thick'])}}
                                        {{Form::select('sex', array('Male' => 'Male','Female' => 'Female') , null, array('class' => 'form-control body-text', 'disabled' => 'disabled', 'id' => 'sex' ));}}
                                    </div>
                                </div>
        
                                <div class="form-row justify-content-center">

                                    <div class="col-md-3 form-group">
                                        {{Form::label('city', 'City', ['class' => 'user_details_label body-text-thick'])}}
                                        {{Form::select('city', array('' => '','Batangas' => 'Batangas') , null, array('class' => 'form-control body-text', 'disabled' => 'disabled', 'id' => 'city' ));}}
                                    </div>
                                    <div class="col-md-3 form-group">
                                        {{Form::label('barangay_code', 'Barangay', ['class' => 'user_details_label body-text-thick'])}}
                                        {{Form::select('barangay_code', array('') , null, array('class' => 'form-control body-text', 'disabled' => 'disabled', 'id' => 'barangay_code' ));}}
                                        {{Form::hidden('barangay', '', ['id' => 'barangay']) }}
                                    </div>
                                    <div class="col-md-6 form-group">
                                        {{Form::label('address_notes', 'Address Notes', ['class' => 'user_details_label body-text-thick'])}}
                                        {{Form::text('address_notes', '', ['class' => 'form-control body-text', 'placeholder' => 'Address Notes', 'id' => 'address_notes',  'readonly' => 'readonly' ]) }}
                                    </div>
                                </div>
        
                                <div class="form-row justify-content-center">
                                    <div class="col-md-4 form-group">
                                        {{Form::label('mobile', 'Mobile Number', ['class' => 'user_details_label body-text-thick'])}}
                                        {{Form::number('mobile', '', ['class' => 'form-control body-text', 'placeholder' => 'Mobile Number', 'required' => 'required', 'id' => 'mobile', 'readonly' => 'readonly' ]) }}
                                    </div>
                                    <div class="col-md-4 form-group">
                                        {{Form::label('email', 'E-Mail Address', ['class' => 'user_details_label body-text-thick'])}}
                                        {{Form::email('email', '', ['class' => 'form-control body-text', 'placeholder' => 'E-Mail Address', 'required' => 'required', 'id' => 'email', 'readonly' => 'readonly' ]) }}
                                    </div>
                                    <div class="col-md-4 form-group">
                                        {{Form::label('membership_code', 'Membership Code', ['class' => 'user_details_label body-text-thick'])}}
                                        {{Form::text('membership_code', '', ['class' => 'form-control body-text', 'placeholder' => 'Membership Code', 'id' => 'membership_code', 'readonly' => 'readonly' ]) }}
                                    </div>
                                </div>
                                        
                                <div style="display: none;" class="form-row pt-2" id="submit_div">
                                    <div class="col-xs-12 col-md-12 text-center">
                                        {{Form::button('Edit User', array(
                                            'type' => 'submit',
                                            'class'=> 'btn page-btn body-text',
                                            'id' => 'edit_user_btn',
                                            )) 
                                        }}
                                        <button type="button" class="btn page-btn body-text" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                                {{Form::hidden('_method', 'PUT')}}
                            {!! Form::close() !!}
                            

                            <div class="row">
                                <div class="col-md-6 col-6 my-auto">
                                    <span class="user_name body-text-thick"></span>'s Total Order/s: <span id="order_count"></span>
                                </div>
                                <div class="col-md-6 col-6 text-right">
                                    <a id="view_orders_btn" class="" href="">
                                        <button type="button" class="btn page-btn">
                                            View <span class="user_name"></span>'s Orders
                                        </button>
                                    </a>
                                </div>
                            </div>
                            

                </div>

            </div>
        </div>
    </div>

    {{-- Markup for Delete User Modal --}}
    <div class="modal fade" id="delete-user-modal" tabindex="-1" role="dialog" aria-labelledby="delete-user-modal" aria-hidden="true">
            
        <div class="modal-dialog modal-md" role="document">

            <div class="modal-content">

                <div class="modal-header pb-2 mb-3">
                    <h5 class="modal-title delete-user-heading" id="delete-user-heading">Delete User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['route' => 'user.deleteUser', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    <div class="modal-body">
                        
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-row justify-content-center">
                                    <div class="col-md-4 form-group text-center">
                                        {{Form::label('delete_user_id', 'User ID', ['class' => 'body-text-thick'])}}
                                        {{Form::text('delete_user_id', '', ['class' => 'form-control body-text text-center', 'placeholder' => 'ID', 'required' => 'required', 'readonly'=>'readonly' ]) }}
                                    </div>
                                    <div class="col-md-8 form-group text-center">
                                        {{Form::label('delete_user_name', 'User Name', ['class' => 'body-text-thick'])}}
                                        {{Form::text('delete_user_name', '', ['class' => 'form-control body-text text-center', 'placeholder' => 'User Name', 'required' => 'required', 'readonly'=>'readonly'  ]) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row justify-content-center">
                            <div class="col-md-12 form-group">
                                <div class="col-md-12 justify-content-center"> 
                                    <p class="delete-user-prompt text-center body-text mb-0">Are you sure you want to remove this User?</p>
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
    {{-- <script type="text/javascript" src="https://f001.backblazeb2.com/file/buonzz-assets/jquery.ph-locations.js" defer></script> --}}
    <script type="text/javascript" src="{{ asset('js/jquery.ph-locations-v1.0.0.js') }}" defer></script>

    <script>

        function setup_ajax() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }

        function toggleEdit(){
            $('#toggle_edit_btn').click(function(){
                if(
                    $('#first_name').prop('readonly') || $('#last_name').prop('readonly') || $('#middle_initial').prop('readonly')
                    || $('#city').attr('disabled') || $('#sex').attr('disabled') || $('#email').prop('readonly')
                    || $('#mobile').prop('readonly') || $('#barangay_code').attr('disabled') || $('#address_notes').prop('readonly') || $('#membership_code').prop('readonly')
                    )
                { 
                    $('#first_name').prop('readonly', false);
                    $('#last_name').prop('readonly', false);
                    $('#middle_initial').prop('readonly', false);
                    $('#city').attr('disabled', false);
                    $('#barangay_code').attr('disabled', false);
                    $('#address_notes').prop('readonly', false);
                    $('#membership_code').prop('readonly', false);
                    $('#sex').attr('disabled', false);
                    $('#email').prop('readonly', false);
                    $('#mobile').prop('readonly', false);
                    $('#submit_div').show();
                }
                else
                {
                    $('#first_name').prop('readonly', true);
                    $('#last_name').prop('readonly', true);
                    $('#middle_initial').prop('readonly', true);
                    $('#city').attr('disabled', true);
                    $('#barangay_code').attr('disabled', true);
                    $('#address_notes').prop('readonly', true);
                    $('#membership_code').prop('readonly', true);
                    $('#sex').attr('disabled', true);
                    $('#email').prop('readonly', true);
                    $('#mobile').prop('readonly', true);
                    $('#submit_div').hide();
                }
            });
        }

        function reset_modal(){
            $('#user-details-modal').on('hidden.bs.modal', function (e) {
                    $('#first_name').val('');
                    $('#last_name').val('');
                    $('#middle_initial').val('');
                    $('#city').val('');
                    $('#barangay_code').val('');
                    $('#address_notes').val('');
                    $('#membership_code').val('');
                    $('#sex').val('');
                    $('#email').val('');
                    $('#mobile').val('');

                    $('#first_name').prop('readonly', true);
                    $('#last_name').prop('readonly', true);
                    $('#middle_initial').prop('readonly', true);
                    $('#city').attr('disabled', true);
                    $('#barangay_code').attr('disabled', true);
                    $('#address_notes').prop('readonly', true);
                    $('#membership_code').prop('readonly', true);
                    $('#sex').attr('disabled', true);
                    $('#email').prop('readonly', true);
                    $('#mobile').prop('readonly', true);
                    $('#submit_div').hide();

                    $("#edit_user_check").html( ``);
            });

            $('#delete-user-modal').on('hidden.bs.modal', function (e) {
                    $('#delete_user_id').val('');
                    $('#delete_user_name').val('');
            });
        }

        function load_user_details()
        {
            $('#user-details-modal').on('show.bs.modal', function (e) {

                setup_ajax();

                var user_id = $(e.relatedTarget).data('user_id');
                $.ajax({
                    type : 'post',
                    url : '/loadUserDetails',
                    
                    data : {user_id:user_id},
                    dataType: 'json',
                    success : function(data)
                    {
                        document.getElementById('city').value = data.user.city;
                        document.getElementById('barangay_code').value  = data.user.barangay_code;
                        document.getElementById('sex').value =  data.user.sex;

                        document.getElementById('user_id').value = data.user.id;
                        document.getElementById('first_name').value = data.user.first_name;
                        document.getElementById('last_name').value = data.user.last_name;
                        document.getElementById('middle_initial').value = data.user.middle_initial;
                        document.getElementById('address_notes').value = data.user.address_notes;
                        document.getElementById('email').value = data.user.email;
                        document.getElementById('mobile').value = data.user.mobile;
                        document.getElementById('membership_code').value = data.user.membership_code;

                        document.getElementsByClassName('user_name')[0].innerHTML = (data.user.first_name+' '+data.user.middle_initial+' '+ data.user.last_name);
                        document.getElementsByClassName('user_name')[1].innerHTML = (data.user.first_name+' '+data.user.middle_initial+' '+ data.user.last_name);
                        document.getElementsByClassName('user_name')[2].innerHTML = (data.user.first_name+' '+data.user.middle_initial+' '+ data.user.last_name);
                        document.getElementById('order_count').innerHTML = data.order_count;

                        $("#view_orders_btn").attr('href','/admin/orders/user/'+data.user.id);
                    },
                    error:function(data)
                    {
                        errormsg = JSON.stringify(data);
                        console.log(errormsg);
                    }
                });
            });
        }

        function load_delete_modal()
        {
            $('#delete-user-modal').on('show.bs.modal', function (e) {

                setup_ajax();

                var user_id = $(e.relatedTarget).data('user_id');
                    $.ajax({
                        type : 'post',
                        url : '/loadUserDetails',
                        
                        data : {user_id:user_id},
                        dataType: 'json',
                        success : function(data)
                        {
                            document.getElementById('delete_user_id').value = data.user.id;
                            document.getElementById('delete_user_name').value = data.user.first_name+' '+data.user.middle_initial+' '+ data.user.last_name;
                        },
                        error:function(data)
                        {
                            errormsg = JSON.stringify(data);
                            console.log(errormsg);
                        }
                    });
            });
        }
        
        function load_barangay()
        {
            $('#barangay_code').ph_locations({'location_type': 'barangays'});
            $('#barangay_code').ph_locations('fetch_list', [{"city_code": "041005"}]);

            $('#city').on('change', function() {
                if(this.value == '')
                {
                    $('#barangay_code')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option value=""></option>')
                    .val(''); 
                }
                else
                {
                    $('#barangay_code').ph_locations('fetch_list', [{"city_code": "041005"}]);
                }
            });
        }

        function set_barangay_value()
        {
            $('#edit_user_form').submit(function(e){
                var barangay = $("#barangay_code option:selected").text();
                document.getElementById('barangay').value = barangay;
            });
        }

        function check_edit_email()
        {
            var current_email;

            $('#user-details-modal').on('show.bs.modal', function (e) {

                var user_id = $(e.relatedTarget).data('user_id');
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

            $('#email').keyup(function()
            {
                var email = $(this).val();
                if(email != '')
                {
                    $.ajax({
                        url: '/checkUserEmail',
                        type: 'post',
                        data: {email: email},
                        success: function(data)
                        { 
                            if(email == current_email && data == true)
                            {
                                $("#edit_user_check").html( ``);
                                document.getElementById("edit_user_btn").disabled = false;
                            }                        
                            else if(email != current_email && data == true)
                            {
                                $("#edit_user_check").html 
                                (
                                    `<div style="text-align:center" class = "alert alert-danger alert-dismissible fade show col-md-6 offset-md-3" role="alert">
                                        Email Already in Use
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>                               
                                    </div>`
                                );
                                document.getElementById("edit_user_btn").disabled = true;
                            }
                            else if(data == false)
                            {
                                $("#edit_user_check").html( ``);
                                document.getElementById("edit_user_btn").disabled = false;
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

        function disable_period()
        {
            $('#middle_initial').keydown(function(e) {
                if (e.keyCode === 190 || e.keyCode === 110) {
                    e.preventDefault();
                }
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

            disable_period();
            load_user_details();
            load_delete_modal();
            reset_modal();
            load_barangay();
            set_barangay_value();
            toggleEdit();
            check_edit_email();

            $('table.display').DataTable({
                "order": [[ 1, "asc" ]]
            });


        });
    </script>
@endsection