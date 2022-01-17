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

		/* Hiding and Showing Fields when Updating Data */
		.user_fields{
			display: none;
		}

		.user_info{
			
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
            color: black;
        }

        .icon{
            color: #4b922d;
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


		/* Footer Navigation Links Style */
		.card-footer a{
            text-decoration: none;
            color: #ffffff;
        }

        .card-footer a:hover{
            text-decoration: none;
            color: #cecece;
        }

		.card-footer{
			background-color: #4b922d;
			color: white;
		}

		.card-header{
			background-color: #4b922d;
			color: white;
		}

		/* Details Button */
		.order-details-button{
			background-color: #096dbe;
		}

		/* Card Title */
		.card-heading{
			font-family: 'Montserrat', sans-serif;
			font-weight: 400;
			font-size: 18px;
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


    </style>
@endsection

@section('content')
		
	<!-- Breadcrumb -->
	<div class="breadcrumb_col">
		<nav aria-label="breadcrumb" class="main-breadcrumb">
			<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/store">Home</a></li>
			<li class="breadcrumb-item"><a href="/user/dashboard">User</a></li>
			<li class="breadcrumb-item active" aria-current="page">User Dashboard</li>
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
						<a href="/user/orders/all" class="links body-text {{ Route::is('user.userOrderAndDelivery') ? 'active' : ' ' }}"><i class="fas fa-clipboard-list"></i> Orders and Deliveries</a>
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
				<div class="col-md-12 order-2 order-sm-2 order-md-2 order-lg-1 ">
					{{-- Card For Order Info Cards --}}
					<div class="row">

						{{-- Card For Pending Orders  --}}
						<div class="col-sm-6 col-md-6 col-lg-3 mb-3">
							<div class="card h-100 info_cards">
								<div class="card-body my-0 px-3 pb-1">
									<div class="row text-center mb-2">
										<div class="col">
											<span class="value card-number-text">
												@if (!empty($pending_orders)){{$pending_orders}}
												@else 0
												@endif
											</span>
										</div>
										<div class="col">
											<i class="fas fa-hourglass-half fa-3x icon "></i>
										</div>
									</div>
									<div class="row">
										<div class="col">
											<span class="label body-text"> Pending Orders </span> 
										</div>
									</div>
								</div>
								<div class="card-footer d-flex">
									<a href="/user/orders/ordered" class="body-text-thin">
										View Pending Orders
										<span class="ms-auto">
											<i class="bi bi-chevron-right"></i>
										</span>
									</a>
								</div>
							</div>
						</div>
						
						{{-- Card For Shipped Orders  --}}
						<div class="col-sm-6 col-md-6 col-lg-3 mb-3">
							<div class="card info_cards h-100">
								<div class="card-body my-0 px-3 pb-1">
									<div class="row text-center mb-2">
										<div class="col">
											<span class="value card-number-text">
												@if (!empty($shipped_orders)){{$shipped_orders}}
												@else 0
												@endif
											</span>
										</div>
										<div class="col">
											<i class="fas fa-truck fa-3x icon "></i>
										</div>
									</div>
									<div class="row">
										<div class="col">
											<span class="label body-text"> Shipped Orders </span> 
										</div>
									</div>
								</div>
								<div class="card-footer d-flex">
									<a href="/user/orders/shipped" class="body-text-thin">
										View Shipped Orders
										<span class="ms-auto">
											<i class="bi bi-chevron-right"></i>
										</span>
									</a>
								</div>
							</div>
						</div>
						
						{{-- Card For Delivered Orders  --}}
						<div class="col-sm-6 col-md-6 col-lg-3 mb-3 ">
							<div class="card info_cards h-100">
								<div class="card-body my-0 px-3 pb-1">
									<div class="row text-center mb-2">
										<div class="col">
											<span class="value card-number-text">
												@if (!empty($delivered_orders)){{$delivered_orders}}
												@else 0
												@endif
											</span>
										</div>
										<div class="col">
											<i class="fas fa-truck-loading fa-3x icon "></i>
										</div>
									</div>
									<div class="row">
										<div class="col">
											<span class="label body-text"> Delivered Orders </span> 
										</div>
									</div>
								</div>
								<div class="card-footer d-flex">
									<a href="/user/orders/delivered" class="body-text-thin">
										View Delivered Orders
										<span class="ms-auto">
											<i class="bi bi-chevron-right"></i>
										</span>
									</a>
								</div>
							</div>
						</div>

						{{-- Card For Canceled Orders  --}}
						<div class="col-sm-6 col-md-6 col-lg-3 mb-3 ">
							<div class="card info_cards h-100">
								<div class="card-body my-0 px-3 pb-1">
									<div class="row text-center mb-2">
										<div class="col">
											<span class="value card-number-text">
												@if (!empty($canceled_orders)){{$canceled_orders}}
												@else 0
												@endif
											</span>
										</div>
										<div class="col">
											<i class="fas fa-window-close fa-3x icon "></i>
										</div>
									</div>
									<div class="row">
										<div class="col">
											<span class="label body-text"> Canceled Orders </span> 
										</div>
									</div>
								</div>
								<div class="card-footer d-flex">
									<a href="/user/orders/canceled" class="body-text-thin">
										View Canceled Orders
										<span class="ms-auto">
											<i class="bi bi-chevron-right"></i>
										</span>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>

				{{-- Personal Info --}}
				<div class="col-md-12  order-1 order-sm-1 order-md-1 order-lg-2">
					{{-- Card For Personal Info --}}
					<div class="card mb-3">
						<div class="card-body">
							<div class="row mb-4">
								<div class="col float-left d-flex align-items-center">
									<i style="vertical-align: middle;" class="fas fa-user-tag fa-2x icon"></i><span class="card-heading my-auto" style="white-space: pre-wrap;"> Personal Info</span>
								</div>
							</div>
							<hr>
							{!! Form::open(['route' => 'user.updateUserInfo', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'edit_user_form']) !!}
								{{Form::hidden('edit_user_id', $user->id, ['id' => 'edit_user_id']) }}

								<div class="row">
									<div class="col-3 col-sm-3 pb-2 my-auto user_info ">
										<h6 class="body-text-thick">Full Name</h6>
									</div>
									<div class="col-9 col-sm-9  pb-2 text-secondary user_info body-text">
										{{$user->first_name . ' ' .$user->middle_initial . ' ' .$user->last_name}}
									</div>

									<div class="col-3 col-sm-3 pb-2 my-auto user_fields">
										<h6 class="body-text-thick">First Name</h6>
									</div>
									<div class="col-9 col-sm-9  pb-2 text-secondary user_fields body-text">
										{{Form::text('edit_first_name', $user->first_name, ['class' => 'form-control mb-0', 'placeholder' => 'First Name', 'required' => 'required', 'id' => 'edit_first_name']) }}
									</div>
								</div>

								<div class="row">
									<div class="col-3 col-sm-3  pb-2 my-auto user_fields">
										<h6 class="body-text-thick">Last Name</h6>
									</div>
									<div class="col-9 col-sm-9 pb-2 text-secondary user_fields float-right body-text">
										{{Form::text('edit_last_name', $user->last_name, ['class' => 'form-control mb-0', 'placeholder' => 'Last Name', 'required' => 'required', 'id' => 'edit_last_name']) }}
									</div>
								</div>
								<div class="row">
									<div class="col-3 col-sm-3 pb-2 my-auto user_fields">
										<h6 class="body-text-thick">Middle Initial</h6>
									</div>
									<div class="col-9 col-sm-9 pb-2 text-secondary user_fields body-text">
										{{Form::text('edit_middle_initial', $user->middle_initial, ['class' => 'form-control mb-0', 'placeholder' => 'Middle Initial', 'required' => 'required', 'id' => 'edit_middle_initial']) }}
									</div>
								</div>
								<hr>

								<div class="row">
									<div class="col-sm-3 col-3 user_info">
										<h6 class="mb-0 body-text-thick">Sex</h6>
									</div>
									<div class="col-sm-9 col-9 text-secondary user_info body-text">
										{{$user->sex}}
									</div>
								</div>

								<div class="row">
									<div class="col-3 col-sm-3 pb-2 my-auto user_fields">
										<h6 class="body-text-thick">Sex</h6>
									</div>
									<div class="col-9 col-sm-9 pb-2 text-secondary user_fields body-text">
										{{Form::select('edit_sex', array('' => '','Male' => 'Male','Female' => 'Female') , $user->sex, array('class' => 'form-control', 'required' => 'required', 'id' => 'edit_sex' ));}}
									</div>
								</div>
								<hr>

								<div class="row">
									<div class="col-sm-3 col-3 user_info">
										<h6 class="mb-0 body-text-thick">Address</h6>
									</div>
									<div class="col-sm-9 col-9 text-secondary user_info body-text">
										{{'Brgy. ' .$user->barangay. ', '. $user->city .' City.'.$user->address_notes}}
									</div>
								</div>

								<div class="row">
									<div class="col-3 col-sm-3 pb-2 my-auto user_fields">
										<h6 class="body-text-thick">City</h6>
									</div>
									<div class="col-9 col-sm-9 pb-2 text-secondary user_fields body-text">
										{{Form::select('edit_city', array('' => '','Batangas' => 'Batangas') , $user->city, array('class' => 'form-control', 'required' => 'required', 'id' => 'edit_city' ));}}
									</div>
								</div>

								<div class="row">
									<div class="col-3 col-sm-3 pb-2 my-auto user_fields">
										<h6 class="body-text-thick">Barangay</h6>
									</div>
									<div class="col-9 col-sm-9 pb-2 text-secondary user_fields body-text">
										{{Form::select('edit_barangay_code', array('') , '', array('class' => 'form-control', 'required' => 'required', 'id' => 'edit_barangay_code' ));}}
										{{Form::hidden('edit_barangay', '', ['id' => 'edit_barangay']) }}
									</div>
								</div>

								<div class="row">
									<div class="col-3 col-sm-3 pb-2 my-auto user_fields">
										<h6 class="body-text-thick">Address Notes</h6>
									</div>
									<div class="col-9 col-sm-9 pb-2 text-secondary user_fields body-text">
										{{Form::text('edit_address_notes',  $user->address_notes, ['class' => 'form-control', 'placeholder' => 'Address Notes', 'id' => 'edit_address_notes' ]) }}
									</div>
								</div>
								<hr>

								<div class="row">
									<div class="col-sm-3 col-3 user_info">
										<h6 class="mb-0 body-text-thick">Mobile Number</h6>
									</div>
									<div class="col-sm-9 col-9 text-secondary user_info body-text">
										{{$user->mobile}}
									</div>
								</div>

								<div class="row">
									<div class="col-sm-12 col-12 col-md-12">
										<div id="edit_mobile_check" class="">

										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-3 col-sm-3 pb-2 my-auto user_fields">
										<h6 class="body-text-thick">Mobile Number</h6>
									</div>
									<div class="col-9 col-sm-9 pb-2 text-secondary user_fields body-text">
										{{Form::number('edit_mobile', $user->mobile, ['class' => 'form-control verify', 'placeholder' => 'Mobile Number', 'required' => 'required', 'id' => 'edit_mobile' ]) }}
									</div>
								</div>
								<hr>

								<div class="row">
									<div class="col-sm-3 col-3 user_info">
										<h6 class="mb-0 body-text-thick">Email Address</h6>
									</div>
									<div class="col-sm-9 col-9 text-secondary user_info body-text">
										{{$user->email}}
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-12 col-12 col-md-12">
										<div id="edit_user_check" class="">

										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-3 col-sm-3 pb-2 my-auto user_fields">
										<h6 class="body-text-thick">Email Address</h6>
									</div>
									<div class="col-9 col-sm-9 pb-2 text-secondary user_fields body-text">
										{{Form::text('edit_email', $user->email, ['class' => 'form-control verify', 'placeholder' => 'Email Address', 'required' => 'required', 'id' => 'edit_email' ]) }}
									</div>
								</div>
								<hr>

								<div class="row">
									<div class="col-sm-3 col-3 user_info">
										<h6 class="mb-0 body-text-thick">Membership Code</h6>
									</div>
									<div class="col-sm-9 col-9 text-secondary user_info body-text">
										{{$user->membership_code}}
									</div>
								</div>

								<div class="row">
									<div class="col-sm-12 col-12 col-md-12">
										<div id="edit_member_code_check" class="">

										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-3 col-sm-3 pb-2 my-auto user_fields">
										<h6 class="body-text-thick">Membership Code</h6>
									</div>
									<div class="col-9 col-sm-9 pb-2 text-secondary user_fields body-text">
										{{Form::text('edit_membership_code', $user->membership_code, ['class' => 'form-control verify', 'placeholder' => 'Membership Code',  'id' => 'edit_membership_code' ]) }}
									</div>
								</div>
								<hr>

								<div class="row">
									<div class="col-sm-4 col-4">
										<button id="toggle_edit_btn" type="button" class="btn page-btn body-text">
											Edit
										</button>
									</div>
									<div class="col-sm-8 col-8 text-right user_fields">
										<button id="save_changes_btn" type="submit" class="btn page-btn body-text">
											Save
										</button>
										<button id="cancel_btn" type="button" class="btn page-btn body-text">
											Cancel
										</button>
									</div>
								</div>
								{{Form::hidden('_method', 'PUT')}}
							{!! Form::close() !!}
						</div>
					</div>
				</div>

				{{-- Recent Orders --}}
				<div class="col-md-12 order-3 order-sm-3 order-md-3 order-lg-3">
					<div class="row gutters-sm">
						<div class="col-sm-12 col-md-12 col-12 mb-3">
							<div class="card h-100">
								<div class="card-body">
									<div class="row mb-3">
										<div class="col d-flex align-items-center">
											<i style="vertical-align: middle;" class="fa fa-history fa-2x icon my-auto" aria-hidden="true"></i> <span style="white-space: pre-wrap;" class="card-heading"> My Recent Orders</span> 
										</div>
										<div class="col text-right d-flex justify-content-end align-items-center">
											<a href="/user/orders/all" class="links body-text">View All Orders <i class="bi bi-chevron-right"></i></a>
										</div>
									</div>
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
																<p class="body-text"><b>Total: </b>₱ {{ number_format($order->total, 2)}}</p>
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
									@else
										<div class="row">
											<div class="col-md-12 text-center">
												<div class="error-template">
													<h2>
														No Orders Found
													</h2>
	
													<div class="error-details">
														You have no orders yet, keep shopping.
													</div>
													<div class="error-actions">
														<a href="#" class="btn page-btn btn-lg">
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
    <div id="print_modal">
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
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col body-text">
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
                                                        <tr class="text-center">
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


	

@endsection

@section('post-scripts')

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

        function load_user_barangay(){

			setup_ajax();

			var user_id = {{ json_encode($user->id, JSON_HEX_TAG) }};

			$.ajax({
			    type : 'post',
			    url : '/loadUserDetails',
				
			    data : {user_id:user_id},
			    dataType: 'json',
			    success : function(data)
			    {
			        document.getElementById('edit_barangay_code').value  = data.user.barangay_code;
			    },
			    error:function(data)
			    {
			        errormsg = JSON.stringify(data);
			        console.log(errormsg);
			    }
			});
		}

        function load_barangay()
        {
            $('#edit_barangay_code').ph_locations({'location_type': 'barangays'});
            $('#edit_barangay_code').ph_locations('fetch_list', [{"city_code": "041005"}]);

            $('#edit_city').on('change', function() {
                if(this.value == '')
                {
                    $('#edit_barangay_code')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option value=""></option>')
                    .val(''); 
                }
                else
                {
                    $('#edit_barangay_code').ph_locations('fetch_list', [{"city_code": "041005"}]);
					load_user_barangay();
                }
            });
        }

        function set_barangay_value()
        {
            $('#edit_user_form').submit(function(e){
                var barangay = $("#edit_barangay_code option:selected").text();
                document.getElementById('edit_barangay').value = barangay;
            });
        }

        function check_edit_email_and_mobile()
        {
            var current_email;
            var current_mobile;
            var current_membership_code;

			var user_id = {{ json_encode($user->id, JSON_HEX_TAG) }};

			$.ajax({
				type : 'post',
				url : '/loadUserDetails',
				
				data : {user_id:user_id},
				dataType: 'json',
				success : function(data)
				{
					current_email = data.user.email;
					current_mobile = data.user.mobile;
					current_membership_code = data.user.membership_code;
				},
				error:function(data)
				{
					errormsg = JSON.stringify(data);
					console.log(errormsg);
				}
			});

			$('input.verify').keyup(function()
            {
                var email = $('#edit_email').val();
                var mobile = $('#edit_mobile').val();
                var membership_code = $('#edit_membership_code').val();

                if(email != '' || mobile != '')
                {
                    $.ajax({
                        url: '/userDashboardCheckEmailAndMobile',
                        type: 'post',
                        data: {email: email, mobile:mobile, membership_code:membership_code},
                        success: function(data)
                        { 

							//Check if Current Credentials in use is the same on what is typed
                            if(mobile == current_mobile && email == current_email && membership_code == current_membership_code && data.emailExists == true && data.mobileExists == true && data.membership_codeExists == true)
                            {
                                $("#edit_user_check").html( ``);
                                $("#edit_mobile_check").html( ``);
								$("#edit_member_code_check").html( ``);
                                document.getElementById("save_changes_btn").disabled = false;
                            }                        
                            else if((email != current_email && data.emailExists == true) || (mobile != current_mobile && data.mobileExists == true) || (membership_code != current_membership_code && data.membership_codeExists == true))
                            {
								//Check if Email is Already Registered
								if(email != current_email && data.emailExists == true)
								{
									$("#edit_user_check").html 
									(
										`<div style="text-align:center" class = "alert alert-danger alert-dismissible fade show col-md-12 col-12" role="alert">
											Email Already in Use
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>                               
										</div>`
									);
								}
								else if(mobile != current_mobile && data.emailExists == false)
								{
									$("#edit_user_check").html( ``);
								}

								//Check if Mobile Number is Already Registered
								if(mobile != current_mobile && data.mobileExists == true)
								{
									$("#edit_mobile_check").html 
									(
										`<div style="text-align:center" class = "alert alert-danger alert-dismissible fade show col-md-12 col-12" role="alert">
											Mobile Number Already Registered
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>                               
										</div>`
									);
								}
								else if(mobile != current_mobile && data.mobileExists == false)
								{
									$("#edit_mobile_check").html( ``);
								}

								//Check if Membership Code is Already Registered
								if(membership_code != current_membership_code && data.membership_codeExists == true)
								{
									$("#edit_member_code_check").html 
									(
										`<div style="text-align:center" class = "alert alert-danger alert-dismissible fade show col-md-12 col-12" role="alert">
											Member Ship Code Already in Use
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>                               
										</div>`
									);
								}
								else if(membership_code != current_membership_code && data.membership_codeExists == false)
								{
									$("#edit_member_code_check").html( ``);
								}
								
								document.getElementById("save_changes_btn").disabled = true;
                            }
                            else
                            {
                                $("#edit_user_check").html( ``);
                                $("#edit_mobile_check").html( ``);
								$("#edit_member_code_check").html( ``);
                                document.getElementById("save_changes_btn").disabled = false;
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

		function reset_fields()
        {
			$("#edit_user_check").html( ``);
			$("#edit_mobile_check").html( ``);
			$("#edit_member_code_check").html( ``);
			document.getElementById("save_changes_btn").disabled = false;
			
			setup_ajax();

			var user_id = {{ json_encode($user->id, JSON_HEX_TAG) }};

			$.ajax({
				type : 'post',
				url : '/loadUserDetails',
				
				data : {user_id:user_id},
				dataType: 'json',
				success : function(data)
				{
					document.getElementById('edit_city').value = data.user.city;
					document.getElementById('edit_barangay_code').value  = data.user.barangay_code;
					document.getElementById('edit_sex').value =  data.user.sex;

					document.getElementById('edit_user_id').value = data.user.id;
					document.getElementById('edit_first_name').value = data.user.first_name;
					document.getElementById('edit_last_name').value = data.user.last_name;
					document.getElementById('edit_middle_initial').value = data.user.middle_initial;
					document.getElementById('edit_address_notes').value = data.user.address_notes;
					document.getElementById('edit_membership_code').value = data.user.membership_code;
					document.getElementById('edit_email').value = data.user.email;
					document.getElementById('edit_mobile').value = data.user.mobile;
				},
				error:function(data)
				{
					errormsg = JSON.stringify(data);
					console.log(errormsg);
				}
			});
        }

		$(document).ready(function(){

			toggleEdit();
			load_order_details();
			clear_order_details();
			load_barangay();
			load_user_barangay();
			check_edit_email_and_mobile();
			set_barangay_value();
			
		});

	</script>

@endsection