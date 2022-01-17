@extends('layouts.app')

@section('scripts')

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"/>

@endsection

@section('styles')
    <style>

		/* Card CSS */

		.info_cards{
			transition: .3s transform cubic-bezier(.155,1.105,.295,1.12),.3s box-shadow,.3s -webkit-transform cubic-bezier(.155,1.105,.295,1.12);
			cursor: pointer;
        }

        .info_cards:hover{
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0,0,0,.12), 0 4px 8px rgba(0,0,0,.06);
        }

		/* Left Side Card Navigation Links */
		.links{
			text-decoration: none;
			color: black;
			background-color: none;
		}

		.links:hover{
			text-decoration: none;
			color: #FD0302;
		}

		.list-group-item .active{
			text-decoration: none;
			color: #FD0302;
		}

		/* Card Contents CSS */

		.label{
			color: black;
        }

        .value{
            text-align: center;
            display: block;
            font-size: 32px;
            font-weight: 400;
            color: black;
        }

        .icon{
            color: #4b922d;
        }

        /* Footer Navigation Links Style */

        .card-footer a{
            text-decoration: none;
            color: #5c5c5c;
        }

        .card-footer a:hover{
            text-decoration: none;
            color: black;
        }

		/* CSS for No Orders Found */
		.error-template {
			padding: 40px 15px;
			text-align: center;
		}

		.error-actions {
			margin-top:15px;
			margin-bottom:15px;
		}

		.error-actions .btn { 
			margin-right:10px; 
		}

		/* CSS For Check */
		.dropdown-item-checked::before {
			position: absolute;
			left: .4rem;
			content: '✓';
			font-weight: 600;
        }

		.pagination{
			justify-content: end;
		}

		/* Details Button */
		.order-details-button{
			background-color: #096dbe;
		}

		/* For Heading in Main Card */
		.card-heading{ 
			font-family: 'Montserrat', sans-serif;
			font-weight: 400;
			font-size: 18px;
			white-space: pre-wrap;
		}

		/* Text in Body */
		.body-text{
			font-family: 'Roboto', sans-serif;
			font-weight: 400;
			font-size: 14px;
		}

		/* Form Label */
		.body-text-thick{
			font-family: 'Roboto', sans-serif;
			font-weight: 500;
			font-size: 14px;
		}

		/* Card Header Navigation Links Style */
		.card-header{
			background-color: #4b922d;
			color: white;
		}

    </style>
@endsection

@section('content')

		
	<!-- Breadcrumb -->
	<div class="breadcrumb_col">
		<nav aria-label="breadcrumb" class="main-breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/store">Home</a></li>
				<li class="breadcrumb-item"><a href="/user/dashboard">User</a></li>
				<li class="breadcrumb-item active" aria-current="page">User Order and Deliveries</li>
			</ol>
		</nav>
	</div>
	<!-- /Breadcrumb -->

	<div class="row gutters-sm">

		{{-- Left Side  --}}
		<div class="col-md-3 mb-3">
			{{-- Card For Navigation  --}}
			<div class="card mb-3 info_cards">
				<ul class="list-group list-group-flush">
					<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
						<a href="/user/dashboard" class="links body-text {{ Route::is('user.userDashboard') ? 'active' : ' ' }}"><i class="fas fa-tachometer-alt"> </i> User Dashboard</a>
					</li>
					<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
						<a href="/user/orders/all" class="links body-text {{ Route::is('user.showOrderAll') || Route::is('user.showOrderOrdered') || Route::is('user.showOrderShipped') || Route::is('user.showOrderDelivered') || Route::is('user.showOrderCanceled') ? 'active' : ' ' }}"><i class="fas fa-clipboard-list"></i> Orders and Deliveries</a>
					</li>
					<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
						<a href="/user/account" class="links body-text {{ Route::is('user.showAccountSettings') ? 'active' : ' ' }}"><i class="fas fa-cog"></i> Account Settings</a>
					</li>
				</ul>
			</div>

		</div>

		{{-- Right Side --}}
		<div class="col-md-9">
			<div class="row">
				<div class="col-md-12 order-3 order-sm-3 order-md-3 order-lg-3">
					{{-- Card Orders --}}
					<div class="row gutters-sm">
						<div class="col-sm-12 col-md-12 col-12 mb-3">
							<div class="card h-100">
								<div class="card-body">
									{{-- Header and Sort Dropdown --}}
									<div class="row mb-3">
										<div class="col d-flex align-items-center" >
											<i style="vertical-align: middle;" class="fa fa-clipboard-list fa-2x icon my-auto" aria-hidden="true"></i> <span class="card-heading my-auto" style="white-space: pre-wrap;"> My Orders</span>
										</div>
										<div class="col text-right">
											<div class="dropdown">
												
												Sort By Status:
												<button class="btn page-btn dropdown-toggle body-text" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													{{ Route::is('user.showOrderAll') ? 'All' : '' }}
													{{ Route::is('user.showOrderOrdered') ? 'Ordered' : '' }}
													{{ Route::is('user.showOrderShipped') ? 'Shipped' : '' }}
													{{ Route::is('user.showOrderDelivered') ? 'Delivered' : '' }}
													{{ Route::is('user.showOrderCanceled') ? 'Canceled' : '' }}

												</button>
												<div class="dropdown-menu body-text" aria-labelledby="dropdownMenuButton">
													<a class="dropdown-item {{ Route::is('user.showOrderAll') ? 'dropdown-item-checked' : '' }}" href="/user/orders/all">All</a>
													<a class="dropdown-item {{ Route::is('user.showOrderOrdered') ? 'dropdown-item-checked' : '' }}" href="/user/orders/ordered">Ordered</a>
													<a class="dropdown-item {{ Route::is('user.showOrderShipped') ? 'dropdown-item-checked' : '' }}" href="/user/orders/shipped">Shipped</a>
													<a class="dropdown-item {{ Route::is('user.showOrderDelivered') ? 'dropdown-item-checked' : '' }}" href="/user/orders/delivered">Delivered</a>
													<a class="dropdown-item {{ Route::is('user.showOrderCanceled') ? 'dropdown-item-checked' : '' }}" href="/user/orders/canceled">Canceled</a>
												</div>
											</div>
										</div>
									</div>
									{{-- Order Cards Display --}}
									@if (count($orders)>0)
										@foreach ($orders as $order)
											<div class="card mb-3">
												<div class="card-header">
													<div class="row">
														<div class="col-md-6 col-8 my-auto body-text">
															Order ID # {{$order->id}}
														</div>
														<div class="col-md-6 col-4 my-auto">
															<div class="float-right">
																<a href="#order-details-modal" class="btn page-btn order-details-button" data-toggle="modal" data-order_id="{{$order->id}}">Details</a>
															</div>
														</div>
													</div>
												</div>
												<div class="card-body">
													<div class="row">
															<div class="col">
																<p class="body-text"><b>Order Date:</b> {{$order->created_at}}</p>
																<p class="body-text"><b>Total:</b> ₱ {{ number_format($order->total, 2)}}</p>
															</div>
															<div class="col">
																<p class="status body-text"> <b>Order Status: </b> 
																	@if ($order->status == 'ordered')Your order is placed and waiting to be processed  
																	@elseif ($order->status == 'shipped')Your order is being shipped, please wait for the delivery.  
																	@elseif ($order->status == 'delivered')Your order is delivered.
																	@elseif ($order->status == 'canceled')Your order is canceled @endif
																</p>
															</div>
													</div>
												</div>
											</div>
											
										@endforeach

									{{-- Pagination for Order Display --}}
									<div class="row ">
										<div class="col">
											{{ $orders->links('pagination::bootstrap-4') }}
										</div>
									</div>

									@else
										<div class="row">
											<div class="col-md-12 text-center">
												<div class="error-template">
													<h2>
														No Orders Found
													</h2>

													<div class="error-details">
														@if (Route::is('user.showOrderAll')) You have no orders yet, keep shopping.
														@elseif (Route::is('user.showOrderOrdered')) You have no orders yet, keep shopping.  
														@elseif (Route::is('user.showOrderShipped')) You have no orders being shipped yet, continue shopping.
														@elseif (Route::is('user.showOrderDelivered')) You have no delivered orders yet, continue shopping.
														@elseif (Route::is('user.showOrderCanceled')) You have no canceled orders, continue shopping.@endif
													</div>
													<div class="error-actions">
														<a href="/store" class="btn page-btn btn-lg">
															<i class="fas fa-shopping-cart"></i>
															Shop
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
										
									@endif
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
	<div class="modal fade" id="order-details-modal" tabindex="-1" role="dialog" aria-labelledby="order-details-modal" aria-hidden="true">
					
		<div class="modal-dialog modal-lg" role="document">

			<div class="modal-content">

				<div class="modal-header">
				
					<h5 class="modal-title order-details-heading my-auto" id="order-details-heading">
						Order Details 
					</h5>
					<div class="row">
						<div class="col">
							
						</div>
						<div class="col">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					</div>
					
				</div>

				<div class="modal-body">

					<div class="row">

						{{-- Shipping Info Card --}}
						<div class="col-md-8">

							<div class="card mt-3">
								<div class="card-header">
									<h5 class="card-heading-text">Shipping Information</h5>
								</div>
								<div class="card-body  body-text">
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
											
											<table class="table table-striped">
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
    
@endsection

@section('post-scripts')

	<script type="text/javascript" src="https://f001.backblazeb2.com/file/buonzz-assets/jquery.ph-locations.js" defer></script>

	<script>

		function load_order_details(){
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

        function setup_ajax() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }


		$(document).ready(function(){
			load_order_details();
			clear_order_details();
		});

	</script>

@endsection