@extends('layouts.adminApp')
@section('scripts')

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"/>
    
@endsection
@section('styles')

    <style>

        /* Card CSS */

        .admin_cards{
            transition: .3s transform cubic-bezier(.155,1.105,.295,1.12),.3s box-shadow,.3s -webkit-transform cubic-bezier(.155,1.105,.295,1.12);
            cursor: pointer;
        }

        .admin_cards:hover{
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0,0,0,.12), 0 4px 8px rgba(0,0,0,.06);
        }

        /* Card Contents CSS */

        .label{
            color: black;
        }

        .value{
            text-align: center;
            display: block;
            color: black;
        }

        .icon{
            color: #4b922d;
        }

        .money{
            text-align: center;
            display: block;
            font-size: 24px;
            font-weight: 400;
            color: black;
        }

        /* Recent Orders CSS */

        .recent_orders_table thead tr, .recent_orders_table tbody tr{
            text-align: center;
        }

        .recent_orders_table tbody tr td a{
            text-decoration: none;
            color: #5c5c5c;
        }

        .recent_orders_table tbody tr td a:hover{
            text-decoration: none;
            color: black;
        }

		/* Text in Body */
		.body-text{
			font-family: 'Roboto', sans-serif;
			font-weight: 400;
			font-size: 14px;
		}

		/* Info Cards Footer */
		.body-text-thin{
			font-family: 'Roboto', sans-serif;
			font-weight: 300;
			font-size: 14px;
		}

		/* Form Label */
		.body-text-thick{
			font-family: 'Roboto', sans-serif;
			font-weight: 500;
			font-size: 14px;
		}

		/* Info Card Numbers */
		.card-number-text{
			font-family: 'Roboto', sans-serif;
			font-weight: 400;
			font-size: 32px;
		}

		/* Info Card Text */
		.card-heading-text{
			font-family: 'Montserrat', sans-serif;
			font-weight: 400;
			font-size: 18px;
		}

        .card-header{
            background-color: #4b922d;
            color: white;
        }

        /* Card Title */
		.card-heading{
			font-family: 'Montserrat', sans-serif;
			font-weight: 400;
			font-size: 18px;
		}

        #notif_icon:hover{
            text-decoration: none;
            color: #085D2A;
        }


    </style>
    
@endsection

@section('content')
    {{-- Breadcrumbs --}}
    <div class="row breadcrumbs_row">
        <div class="col-md-8 col-8 align-self-center breadcrumb_col">
            <h3 class="text-themecolor mb-0">Administrator Dashboard</h3>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                <a href="/admin/dashboard">Administrator</a>
                </li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>

        <div class="col-md-4 col-4 align-self-center breadcrumb_col text-right">
        
            <div class="dropdown dropdown-notifications" id="dropdown-notifications">
                <a href="#" class="dropdown-toggle icon" data-toggle="dropdown" id="notif_icon">
                    <i style="vertical-align: middle;" data-count="0" class="fas fa-bell fa-3x "></i>(<span class="notif-count" style="font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 16px;" id="notif-count">0</span>)
                </a>
    
                <ul class="dropdown-menu" id="notification_menu">
                    
                </ul>
            </div>
        </div>

    </div>

    <div class="row">
        
        {{-- Registered Accounts Card --}}
        <div class="col-md-3 mb-3">
            <div class="card bg-white text-dark h-100 admin_cards">
                <div class="card-body my-0 px-3 pb-1">
                    <div class="row ">
                        <div class="col my-auto">
                           <span class="value card-number-text">
                               @if (!empty($registered_accounts)){{$registered_accounts}}
                               @else 0
                               @endif
                            </span>
                        </div>
                        <div class="col my-auto">
                            <i class="fas fa-users fa-3x icon"></i>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                           <span class="label body-text"> Registered Account(s) </span> 
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex">
                    <a href="/admin/accounts" class="body-text-thin">
                        View Account(s)
                        <span class="ms-auto">
                            <i class="bi bi-chevron-right"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Low on Stocks Card--}}
        <div class="col-md-3 mb-3">
            <div class="card bg-white text-dark h-100 admin_cards">
                <div class="card-body my-0 px-3 pb-1">
                    <div class="row ">
                        <div class="col my-auto">
                           <span class="value card-number-text"> 
                            @if (!empty($low_on_stock)){{$low_on_stock}}
                            @else 0
                            @endif
                           </span>
                        </div>
                        <div class="col my-auto">
                            <i class="fas fa-pallet fa-3x icon"></i>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                           <span class="label body-text"> Low on Stock Item(s) </span> 
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex">
                    <a href="/admin/inventory/lowOnStock" class="body-text-thin">
                        View Low on Stock Item(s)
                        <span class="ms-auto">
                            <i class="bi bi-chevron-right"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Pending Orders Card--}}
        <div class="col-md-3 mb-3" id="pending_card">
            <div class="card bg-white text-dark h-100 admin_cards" >
                <div class="card-body my-0 px-3 pb-1">
                    <div class="row ">
                        <div class="col my-auto">
                           <span class="value card-number-text">
                                @if (!empty($pending_orders)){{$pending_orders}}
                                @else 0
                                @endif
                           </span>
                        </div>
                        <div class="col my-auto">
                            <i class="fas fa-hourglass-half fa-3x icon"></i>
                        </div>
                    </div>
                    <div class="row">
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
                        <div class="col my-auto">
                           <span class="value card-number-text">
                                @if (!empty($being_delivered)){{$being_delivered}}
                                @else 0
                                @endif
                           </span>
                        </div>
                        <div class="col my-auto">
                            <i class="fas fa-truck fa-3x icon"></i>
                        </div>
                    </div>
                    <div class="row">
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

    </div>

    <div class="row">

        {{-- Recent Orders Table Markup --}}
        <div class="col-md-6 mb-3" id="recent_orders">
            <div class="row">
                <div class="col-md-12 mb-3">
                  <div class="card admin_cards">
                    <div class="card-header">
                      <span class="card-title"><i class="bi bi-table me-2"></i>  Recent Orders</span> 
                    </div>
                    <div class="card-body body-text ">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped data-table display recent_orders_table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @if (!empty($latest_orders)){{$latest_orders}} --}}
                                        @foreach ( $latest_orders as $latest_order )
                                            <tr>
                                                <td>
                                                    <a href="/admin/orders/{{$latest_order->id}}">{{$latest_order->id}}</a>
                                                </td>
                                                <td>
                                                    <a href="/admin/orders/{{$latest_order->id}}">{{'₱ '.number_format($latest_order->total, 2)}}</a>
                                                </td>
                                                <td>
                                                    @if ($latest_order->status == 'ordered')<a href="/admin/orders/{{$latest_order->id}}"><h5><span class="badge badge-warning">Ordered</span></h5></a>
                                                    @elseif ($latest_order->status == 'shipped')<a href="/admin/orders/{{$latest_order->id}}"><h5><span class="badge badge-primary">Shipped</span></h5></a>
                                                    @elseif ($latest_order->status == 'delivered')<a href="/admin/orders/{{$latest_order->id}}"><h5><span class="badge badge-success">Delivered</span></h5></a>
                                                    @elseif ($latest_order->status == 'canceled')<a href="/admin/orders/{{$latest_order->id}}"><h5><span class="badge badge-danger">Canceled</span></h5></a>
                                                    @endif
                                                </td>
                                            </tr> 
                                        @endforeach
                                    {{-- @endif --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
        </div>

        {{-- Sales --}}
        <div class="col-md-6 mb-3">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="card bg-white text-dark h-100 admin_cards">
                        <div class="card-body my-0 px-3 pb-1">
                            <div class="row ">
                                <div class="col my-auto">
                                   <span class="value card-number-text">
                                        @if (!empty($todays_sales)){{$todays_sales}}
                                        @else 0
                                        @endif
                                   </span>
                                </div>
                                <div class="col my-auto">
                                    <i class="fas fa-cash-register fa-3x icon"></i>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                   <span class="label body-text">Today's Sales</span> 
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex">
                            <a href="/admin/orders/todaySales" class="body-text-thin">
                                View Today's Sales
                                <span class="ms-auto">
                                    <i class="bi bi-chevron-right"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card bg-white text-dark h-100 admin_cards">
                        <div class="card-body  my-0 px-3 pb-1">
                            <div class="row ">
                                <div class="col my-auto">
                                   <span class="money">₱ 
                                        @if (!empty($todays_revenue)){{number_format($todays_revenue)}}
                                        @else 0
                                        @endif
                                   </span>
                                </div>
                                <div class="col my-auto">
                                    <i class="fas fa-coins fa-3x icon"></i>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                   <span class="label body-text">Today's Revenue</span> 
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex">
                            <a href="/admin/orders/todaySales" class="body-text-thin">
                                View Today's Revenue
                                <span class="ms-auto">
                                    <i class="bi bi-chevron-right"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3 d-flex align-items-stretch">
                    <div class="card bg-white text-dark w-100 admin_cards">
                        <div class="card-body  my-0 px-3 pb-1">
                            <div class="row ">
                                <div class="col my-auto">
                                   <span class="value card-number-text">
                                        @if (!empty($total_sales)){{$total_sales}}
                                        @else 0
                                        @endif
                                   </span>
                                </div>
                                <div class="col my-auto">
                                    <i class="fas fa-cash-register fa-3x icon"></i>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                   <span class="label body-text">Total Sales</span> 
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex">
                            <a href="/admin/orders/totalSales" class="body-text-thin">
                                View Total Sales
                                <span class="ms-auto">
                                    <i class="bi bi-chevron-right"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div><div class="col-md-6 mb-3 d-flex align-items-stretch">
                    <div class="card bg-white text-dark w-100 admin_cards">
                        <div class="card-body  my-0 px-3 pb-1">
                            <div class="row ">
                                <div class="col my-auto">
                                   <span class="money">₱
                                        @if (!empty($total_revenue)){{number_format($total_revenue)}}
                                        @else 0
                                        @endif
                                   </span>
                                </div>
                                <div class="col my-auto">
                                    <i class="fas fa-coins fa-3x icon"></i>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                   <span class="label body-text">Total Revenue</span> 
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex">
                            <a href="/admin/orders/totalSales" class="body-text-thin">
                                View Total Revenue
                                <span class="ms-auto">
                                    <i class="bi bi-chevron-right"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('post-scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js" defer></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

    <script>

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
            var notificationsWrapper   = $('.dropdown-notifications');
            var notificationsToggle    = notificationsWrapper.find('a[data-toggle]');
            var notificationsCountElem = notificationsToggle.find('i[data-count]');
            var notificationsCount     = parseInt(notificationsCountElem.data('count'));
            var notifications          = notificationsWrapper.find('#notification_menu');

			// Enable pusher logging - don't include this in production
			Pusher.logToConsole = true;
            
			var pusher = new Pusher('03527b096d7dc99cecc1', {
				cluster: 'ap1'
			});

			var channel = pusher.subscribe('admin-channel');
			channel.bind('order-placed-event', function(data) {

                var existingNotifications = notifications.html();
                var newNotificationHtml = 
                `
                    <li><a class="dropdown-item" href="/admin/orders/ordered"> ${data.message['text']} </a></li>
                `;
                notifications.html(newNotificationHtml + existingNotifications);
                
                notificationsCount += 1;
                notificationsCountElem.attr('data-count', notificationsCount);
                notificationsWrapper.find('#notif-count').text(notificationsCount);    

                $( "#pending_card" ).load(" #pending_card > *" );
                $( "#recent_orders" ).load(" #recent_orders > *" );
                
                //Desktop Push Notif
                if(Notification.permission == 'granted')
                {   
                    showNotification(data.message['text']);
                }

			});
		}


        $(document).ready(function(){
            
            register_sw();

            realtime_notif();
            ask_notif_permission();
            
        });

    </script>

@endsection