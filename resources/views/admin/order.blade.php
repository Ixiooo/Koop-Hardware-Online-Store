@extends('layouts.adminApp')

@section('scripts')
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">

@endsection

@section('styles')

    <style>
        /* CSS for Print */
        @media screen {
            #printSection {
                display: none;
            }
        }

        @media print {
            
            #print_btn {
                display: none;
            }

            .status{
                display: none;
            }

            body * {
                visibility:hidden;
            }

            img{
                vertical-align: middle;
            }

            #printSection, #printSection * {
                visibility:visible;
            }
            #printSection {
                position: absolute;
                left:0px;
                top:0px;
                bottom: 0px;
                right: 0px;
                -webkit-print-color-adjust: exact;
                
            }

            table,
            table tr td,
            table tr th {
                page-break-inside: avoid !important;
            }

            table,
            table tr th {
                position: sticky;
                top: 0; 
            }

            .modal {
                position: relative;
                overflow: visible !important;
                
            } 
            .modal-body {
                width: 100%;
                overflow: visible !important;

            }
            .modal-dialog{
                visibility: visible !important;
                overflow: visible !important;
            }
        }

        /* CSS For Page */
        .orders_table{
            overflow-x: scroll;
        }

        .orders_table thead tr th{
            text-align: center;
        }
        .orders_table tbody tr td{
            text-align: center;
        }

        .dataTables_length, .dataTables_filter{
            padding-top: 10px;
            padding-left: 5px;
            padding-right: 5px;
        }
        
        table.dataTable thead th {
            border-bottom: none;
        }

        /* CSS For Check */
        .dropdown-item-checked::before {
            position: absolute;
            left: .4rem;
            content: '✓';
            font-weight: 600;
        }

        /* CSS For Order Items Card Table */
        .order_items_table thead tr th
        {
            text-align: center;
        }

        .order_items_table tbody tr td{
            text-align: center;
        }

    </style>

@endsection

@section('content')

    {{-- Breadcrumbs --}}
    <div class="row breadcrumbs_row">
        <div class="col-md-6 col-12 align-self-center breadcrumb_col">
            <h3 class="text-themecolor mb-0">Order & Delivery</h3>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                <a href="/admin/dashboard">Administrator</a>
                </li>
                <li class="breadcrumb-item active">Order & Delivery</li>
            </ol>
        </div>

        <div class="col-md-6 col-12">
            <div class="row">
                <div class="col my-auto pr-0">
                    <span class="value card-number-text text-right">
                        @if (!empty($total_orders)){{$total_orders}}
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
                    <span class="label body-text"> Total Order(s)</span> 
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        
        {{-- Pending Orders Card--}}
        <div class="col-md-3 mb-3" id="pending_card">
            <div class="card bg-white text-dark h-100 admin_cards">
                <div class="card-body  my-0 px-3 pb-1">
                    <div class="row ">
                        <div class="col my-auto pr-0">
                           <span class="value card-number-text text-right">
                                @if (!empty($pending_orders)){{$pending_orders}}
                                @else 0
                                @endif
                           </span>
                        </div>
                        <div class="col my-auto">
                            <i class="fas fa-hourglass-half fa-3x icon"></i>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="col">
                           <span class="label body-text"> Pending Order(s) </span> 
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex">
                    <a href="/admin/orders/ordered" class="body-text-thin">
                        View Pending Order(s)
                        <span class="ms-auto">
                            <i class="bi bi-chevron-right"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Being Shipped Card --}}
        <div class="col-md-3 mb-3">
            <div class="card bg-white text-dark h-100 admin_cards">
                <div class="card-body  my-0 px-3 pb-1">
                    <div class="row ">
                        <div class="col my-auto pr-0">
                           <span class="value card-number-text text-right">
                                @if (!empty($being_delivered)){{$being_delivered}}
                                @else 0
                                @endif
                           </span>
                        </div>
                        <div class="col my-auto">
                            <i class="fas fa-truck fa-3x icon"></i>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="col">
                           <span class="label body-text"> Being Shipped </span> 
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex">
                    <a href="/admin/orders/shipped" class="body-text-thin">
                        View Shipped Order(s)
                        <span class="ms-auto">
                            <i class="bi bi-chevron-right"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Delivered Orders Card--}}
        <div class="col-md-3 mb-3">
            <div class="card bg-white text-dark h-100 admin_cards">
                <div class="card-body  my-0 px-3 pb-1">
                    <div class="row ">
                        <div class="col my-auto pr-0">
                           <span class="value card-number-text text-right">
                                @if (!empty($delivered_orders)){{$delivered_orders}}
                                @else 0
                                @endif
                           </span>
                        </div>
                        <div class="col my-auto">
                            <i class="fas fa-truck-loading fa-3x icon"></i>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-center">
                           <span class="label body-text"> Delivered Order(s) </span> 
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex">
                    <a href="/admin/orders/delivered" class="body-text-thin">
                        View Delivered Order(s)
                        <span class="ms-auto">
                            <i class="bi bi-chevron-right"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Canceled Shipped Card --}}
        <div class="col-md-3 mb-3">
            <div class="card bg-white text-dark h-100 admin_cards">
                <div class="card-body  my-0 px-3 pb-1">
                    <div class="row ">
                        <div class="col my-auto pr-0">
                           <span class="value card-number-text text-right">
                                @if (!empty($canceled_orders)){{$canceled_orders}}
                                @else 0
                                @endif
                           </span>
                        </div>
                        <div class="col my-auto">
                            <i class="fas fa-window-close fa-3x icon"></i>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="col">
                           <span class="label body-text"> Canceled Order(s) </span> 
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex">
                    <a href="/admin/orders/canceled" class="body-text-thin">
                        View Canceled Order(s)
                        <span class="ms-auto">
                            <i class="bi bi-chevron-right"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>

    </div>
    
    <div class="row">
        <div class="col">
                <div>
                    <div class="row pt-3">
                        <div class="col">
                            <div class="card ">
                                {{-- Markup for Orders Table --}}
                                <div class="card-body" id="orders_table">
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <span class="card-heading">
                                                {{ Route::is('admin.showOrderAll') ? 'All Orders' : '' }}
                                                {{ Route::is('admin.showOrderOrdered') ? 'Pending Orders' : '' }}
                                                {{ Route::is('admin.showOrderShipped') ? 'Shipped Orders' : '' }}
                                                {{ Route::is('admin.showOrderDelivered') ? 'Delivered Orders' : '' }}
                                                {{ Route::is('admin.showOrderCanceled') ? 'Canceled Orders' : '' }}
                                            </span>
                                        </div>
                                        <div class="col-md-6">
                                            @if(!Route::is('admin.showUserOrders')  && !Route::is('admin.showOrder') && !Route::is('admin.showTodaySales') && !Route::is('admin.showTotalSales'))
                                                <div class="dropdown float-right body-text">
                                                        
                                                    Sort By Status:
                                                    <button class="btn page-btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        {{ Route::is('admin.showOrderAll') ? 'All' : '' }}
                                                        {{ Route::is('admin.showOrderOrdered') ? 'Ordered' : '' }}
                                                        {{ Route::is('admin.showOrderShipped') ? 'Shipped' : '' }}
                                                        {{ Route::is('admin.showOrderDelivered') ? 'Delivered' : '' }}
                                                        {{ Route::is('admin.showOrderCanceled') ? 'Canceled' : '' }}

                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item {{ Route::is('admin.showOrderAll') ? 'dropdown-item-checked' : '' }}" href="/admin/orders">All</a>
                                                        <a class="dropdown-item {{ Route::is('admin.showOrderOrdered') ? 'dropdown-item-checked' : '' }}" href="/admin/orders/ordered">Ordered</a>
                                                        <a class="dropdown-item {{ Route::is('admin.showOrderShipped') ? 'dropdown-item-checked' : '' }}" href="/admin/orders/shipped">Shipped</a>
                                                        <a class="dropdown-item {{ Route::is('admin.showOrderDelivered') ? 'dropdown-item-checked' : '' }}" href="/admin/orders/delivered">Delivered</a>
                                                        <a class="dropdown-item {{ Route::is('admin.showOrderCanceled') ? 'dropdown-item-checked' : '' }}" href="/admin/orders/canceled">Canceled</a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="table-responsive" id="orders_table">
                                        <table id="orders_table_sort" class="table table-striped orders_table mt-2 display">
                                            <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Address</th>
                                                    <th>Total</th>
                                                    <th>Order Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                    <th>Action</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($orders as $order)
                                                    
                                                    <tr>
                                                        
                                                        <td>{{$order->id}}</td>
                                                        <td>{{$order->first_name.' '.$order->last_name}}</td>
                                                        <td>{{$order->email}}</td>
                                                        <td>{{$order->address}}</td>
                                                        <td>{{number_format($order->total,2)}}</td>
                                                        <td>{{$order->created_at}}</td>
                                                        <td>
                                                            @if ($order->status == 'ordered')Ordered 
                                                            @elseif ($order->status == 'shipped')Shipped 
                                                            @elseif ($order->status == 'delivered')Delivered 
                                                            @elseif ($order->status == 'canceled')Canceled @endif
                                                        </td>

                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn page-btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    @if ($order->status == 'ordered')Ordered 
                                                                    @elseif ($order->status == 'shipped')Shipped 
                                                                    @elseif ($order->status == 'delivered')Delivered 
                                                                    @elseif ($order->status == 'canceled')Canceled @endif
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                                {!! Form::open(['route' => 'orders.updateStatusOrdered', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                                                {!! Form::hidden('order_id', $order->id)!!}
                                                                @csrf
                                                                    <button class="dropdown-item {{$order->status == 'ordered' ? 'dropdown-item-checked' : '';}}" type="submit">Ordered</button >
                                                                {!! Form::close() !!}

                                                                {!! Form::open(['route' => 'orders.updateStatusShipped', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                                                {!! Form::hidden('order_id', $order->id)!!}
                                                                @csrf
                                                                    <button class="dropdown-item {{$order->status == 'shipped' ? 'dropdown-item-checked' : '';}}" type="submit">Shipped</button >
                                                                {!! Form::close() !!}

                                                                {!! Form::open(['route' => 'orders.updateStatusDelivered', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                                                {!! Form::hidden('order_id', $order->id)!!}
                                                                @csrf
                                                                    <button class="dropdown-item {{$order->status == 'delivered' ? 'dropdown-item-checked' : '';}}" type="submit">Delivered</button >
                                                                {!! Form::close() !!}

                                                                {!! Form::open(['route' => 'orders.updateStatusCanceled', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                                                {!! Form::hidden('order_id', $order->id)!!}
                                                                @csrf
                                                                    <button class="dropdown-item {{$order->status == 'canceled' ? 'dropdown-item-checked' : '';}}" type="submit">Canceled</button >
                                                                {!! Form::close() !!}

                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a class="" href="#order-details-modal" data-toggle="modal" data-order_id="{{$order->id}}" >
                                                                <button type="button" class="btn page-btn">
                                                                    Details
                                                                </button>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a class="" href="#delete-order-modal" data-toggle="modal" data-order_id="{{$order->id}}" >
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
                </div>
            
        </div>
    </div>

    {{-- Modals --}}
    
    {{-- Markup for Order Details Modal --}}
    <div>
        <div class="modal fade" id="order-details-modal" tabindex="-1" role="dialog" aria-labelledby="order-details-modal" aria-hidden="true">
                        
            <div class="modal-dialog modal-lg" role="document">

                <div id="print_modal"  class="modal-content">

                    <div class="modal-header">
                    
                        <h5 class="modal-title order-details-heading my-auto" id="order-details-heading">
                            Order Details 
                        </h5>
                        <div class="row">
                            <div class="col">
                                <button id="print_btn" class="btn page-btn float-right" type="button">
                                    <i class="fas fa-print"></i>
                                </button>
                            </div>
                            <div class="col">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        
                    </div>

                    <div  class="modal-body">

                        <div class="row">

                            {{-- Shipping Info Card --}}
                            <div class="col-md-8">

                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h5 class="card-heading-text">Shipping Information</h5>
                                    </div>
                                    <div class="card-body body-text">
                                        <p id="name"> </p>
                                        <p id="email"> </p>
                                        <p id="address"> </p>
                                        <p id="mobile"> </p>
                                    </div>
                                </div>

                            </div>

                            {{-- Order Summary Card --}}
                            <div class="col-md-4">
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h5 class="card-heading-text">Order Summary</h5>
                                    </div>
                                    <div class="card-body body-text">
                                        <div class="row">
                                            <div class="col">
                                                <p class="status">Status: <b id="status" class="status"></b></p>
                                                <hr>
                                                <p>Total: ₱ <b id="total" class="index"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- Order Items Card --}}
                        <div class="row">
                            <div class="col">

                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h5 class="card-heading-text">Ordered Items</h5>
                                    </div>
                                    <div class="card-body body-text">

                                        <div class="table-responsive">
                                            <div class="order_items_table" id="order_items_table">
                                                
                                                <table class="table table-striped text-center">
                                                    <thead>
                                                        <tr>
                                                            <th>Image</th>
                                                            <th>Name</th>
                                                            <th>Quantity</th>
                                                            <th>Price</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td id="product_image"></td>
                                                            <td id="product_name"></td>
                                                            <td id="product_quantity"></td>
                                                            <td id="product_price"></td>
                                                        </tr>
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
        </div>
    </div>

    {{-- Markup for Delete Order Modal --}}
    <div class="modal fade" id="delete-order-modal" tabindex="-1" role="dialog" aria-labelledby="delete-order-modal" aria-hidden="true">
            
        <div class="modal-dialog modal-md" role="document">

            <div class="modal-content">

                <div class="modal-header pb-2 mb-3">
                    <h5 class="modal-title delete-order-heading" id="delete-order-heading">Delete Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['route' => 'user.deleteOrder', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    <div class="modal-body">
                        
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-row justify-content-center">
                                    <div class="col-md-4 form-group text-center">
                                        {{Form::label('delete_order_id', 'Order ID', ['class' => 'body-text-thick'])}}
                                        {{Form::text('delete_order_id', '', ['class' => 'form-control body-text text-center', 'placeholder' => 'Order ID', 'required' => 'required', 'readonly'=>'readonly' ]) }}
                                    </div>
                                    <div class="col-md-8 form-group text-center">
                                        {{Form::label('delete_order_name', 'Order Recipient', ['class' => 'body-text-thick'])}}
                                        {{Form::text('delete_order_name', '', ['class' => 'form-control body-text text-center', 'placeholder' => 'Order Recipient', 'required' => 'required', 'readonly'=>'readonly'  ]) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row justify-content-center">
                                <div class="col-md-12 justify-content-center"> 
                                    <p class="delete-order-prompt text-center body-text">Are you sure you want to remove this Order Record?</p>
                                </div>   
                        </div>

                    </div>

                    <div class="modal-footer">
                        <div class="form-row mx-auto">
                            <div class="col-xs-12 col-md-12 ">
                                {{Form::hidden('_method', 'DELETE')}}
                                {{Form::button('Delete', array('type' => 'submit','class'=> 'btn page-btn body-text',)) 
                                }}
                                <button type="button" class="btn page-btn body-text" data-dismiss="modal">Cancel</button>
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

        function load_order_details()
        {
            $('#order-details-modal').on('show.bs.modal', function (e) {

                setup_ajax();

                var order_id = $(e.relatedTarget).data('order_id');
                var status = '';
                $.ajax({
                    type : 'post',
                    url : '/loadOrderDetails',
                    
                    data : {order_id:order_id},
                    dataType: 'json',
                    success : function(data)
                    {
                        jQuery('#order_items_table').html(data.html);
                        document.getElementById('name').innerHTML = (data.orders.first_name + ' ' + data.orders.middle_initial + '. ' + data.orders.last_name);
                        document.getElementById('email').innerHTML = data.orders.email;
                        document.getElementById('address').innerHTML = data.orders.address;
                        document.getElementById('mobile').innerHTML = data.orders.mobile;

                        if(data.orders.status === 'ordered')
                        {
                            status = 'Ordered';
                        }
                        else if(data.orders.status === 'shipped')
                        {
                            status = 'Shipped';
                        }
                        else if(data.orders.status === 'delivered')
                        {
                            status = 'Delivered';
                        }
                        else if(data.orders.status === 'canceled')
                        {
                            status = 'Canceled';
                        }

                        let nf = new Intl.NumberFormat('en-US');

                        document.getElementById('status').innerHTML = status;
                        document.getElementById('total').innerHTML = nf.format(data.orders.total);

                    },
                    error:function(data)
                    {
                        errormsg = JSON.stringify(data);
                        console.log(errormsg);
                    }
                });
            });
        }

        function print_order_details()
        {
            document.getElementById("print_btn").onclick = function() {
                printElement(document.getElementById("print_modal"));
                window.print();
            }

            function printElement(elem, append, delimiter) {
                var domClone = elem.cloneNode(true);

                var $printSection = document.getElementById("printSection");

                if (!$printSection) {
                    var $printSection = document.createElement("div");
                    $printSection.id = "printSection";
                    document.body.appendChild($printSection);
                }

                if (append !== true) {
                    $printSection.innerHTML = "";
                }

                else if (append === true) {
                    if (typeof(delimiter) === "string") {
                        $printSection.innerHTML += delimiter;
                    }
                    else if (typeof(delimiter) === "object") {
                        $printSection.appendChlid(delimiter);
                    }
                }

                $printSection.appendChild(domClone);
            }
        }

        function clear_order_details(){
			$('#order-details-modal').on('hidden.bs.modal', function (e) {

				jQuery('#order_items_table').html('');
				document.getElementById('name').innerHTML = ('');
				document.getElementById('email').innerHTML = ('');
				document.getElementById('address').innerHTML = ('');
				document.getElementById('mobile').innerHTML = ('');
				document.getElementById('status').innerHTML = ('');
				document.getElementById('total').innerHTML = ('');

			});
        }

        function clear_modal()
        {
            $('#delete-order-modal').on('hidden.bs.modal', function (e) {

                // $('#product_name').val('');
                // $('#product_category').val('');
                // $('#product_description').val('');
                // $('#product_price').val('');
                // $('#product_stock').val('');
               
            });
        }

        function load_delete_modal()
        {
            $('#delete-order-modal').on('show.bs.modal', function (e) {

                setup_ajax();

                var order_id = $(e.relatedTarget).data('order_id');
                    $.ajax({
                        type : 'post',
                        url : '/loadOrderDetails',
                        
                        data : {order_id:order_id},
                        dataType: 'json',
                        success : function(data)
                        {
                            document.getElementById('delete_order_id').value = data.orders.id;
                            document.getElementById('delete_order_name').value = data.orders.first_name+' '+data.orders.middle_initial+'. '+ data.orders.last_name;
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

            print_order_details();
            load_order_details();
            clear_order_details();
            load_delete_modal();
            $('table.display').DataTable({
                "order": [[ 5, "asc" ]]
            });

        });
    </script>

@endsection