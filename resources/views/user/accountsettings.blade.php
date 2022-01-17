@extends('layouts.app')

@section('scripts')

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"/>

@endsection

@section('styles')
    <style>

		/* Hiding and Showing Fields when Updating Data */
		.user_fields{
			display: none;
		}

		.user_info{
			
		}
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
				<div class="col-md-12 order-3 order-sm-3 order-md-3 order-lg-3">
					<div class="row gutters-sm">
						<div class="col-sm-12 col-md-12 col-12 mb-3">
							<div class="card h-100">
								<div class="card-body">
									<div class="row mb-3">
										<div class="col d-flex align-items-center" >
											<i style="vertical-align: middle;" class="fas fa-user-cog fa-2x icon my-auto" aria-hidden="true"></i> <span class="card-heading"> Account Settings</span>
										</div>
									</div>
									
									<hr>
									{!! Form::open(['route' => 'user.changeUserPassword', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'edit_user_form']) !!}
									{{Form::hidden('edit_user_id', $user->id, ['id' => 'edit_user_id']) }}
	
									<div class="row">

										<div class="col-6 my-auto user_info">
											<h6 class="body-text-thick">Update Account Password</h6>
										</div>
										<div class="col-6 my-auto text-right">
											<button id="toggle_edit_btn" type="button" class="btn page-btn body-text">
												Change Password
											</button>
										</div>
									</div>
	
									<div class="row">
										<div class="col-4 col-sm-4 pb-2 my-auto user_fields">
											<h6 class="body-text-thick">Current Password</h6>
										</div>
										<div class="col-8 col-sm-8 pb-2 text-secondary user_fields float-right body-text">
											{{Form::password('current_password', ['class' => 'form-control mb-0', 'placeholder' => 'Current Password', 'required' => 'required', 'id' => 'current_password']) }}
										</div>
									</div>

									<div class="row">
										<div class="col-4 col-sm-4 pb-2 my-auto user_fields">
											<h6 class="body-text-thick">New Password</h6>
										</div>
										<div class="col-8 col-sm-8 pb-2 text-secondary user_fields body-text">
											{{Form::password('new_password',  ['class' => 'form-control mb-0', 'placeholder' => 'New Password', 'required' => 'required', 'id' => 'new_password']) }}
										</div>
									</div>

									<div class="row">
										<div class="col-4 col-sm-4 pb-2 my-auto user_fields">
											<h6 class="body-text-thick">Confirm New Password</h6>
										</div>
										<div class="col-8 col-sm-8 pb-2 text-secondary user_fields body-text">
											{{Form::password('confirm_new_password', ['class' => 'form-control mb-0', 'placeholder' => 'Confirm New Password', 'required' => 'required', 'id' => 'confirm_new_password']) }}
										</div>
									</div>
									<hr>
	
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

		$(document).ready(function(){
			toggleEdit();
		});

	</script>

@endsection