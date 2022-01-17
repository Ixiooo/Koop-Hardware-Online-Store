<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ (isset($title) ? $title : 'Koop Hardware' ) }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        @yield('scripts')

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"/>
      
        {{-- Pusher Notif --}}
        <script src="https://js.pusher.com/7.0.3/pusher.min.js"></script>
        <script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        {{-- Google Fonts --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="icon" href="/storage/logo/icon.png">

      {{-- Sidebar CSS --}}
    <style>
        body{
            background-color: #F1F5FB;
        }

          @keyframes swing {
              0% {
                  transform: rotate(0deg);
              }
              10% {
                  transform: rotate(10deg);
              }
              30% {
                  transform: rotate(0deg);
              }
              40% {
                  transform: rotate(-10deg);
              }
              50% {
                  transform: rotate(0deg);
              }
              60% {
                  transform: rotate(5deg);
              }
              70% {
                  transform: rotate(0deg);
              }
              80% {
                  transform: rotate(-5deg);
              }
              100% {
                  transform: rotate(0deg);
              }
          }

          @keyframes sonar {
              0% {
                  transform: scale(0.9);
                  opacity: 1;
              }
              100% {
                  transform: scale(2);
                  opacity: 0;
              }
              }
          body {
              font-size: 0.9rem;
          }
          .page-wrapper .sidebar-wrapper,
          .sidebar-wrapper .sidebar-brand > a,
          .sidebar-wrapper .sidebar-dropdown > a:after,
          .sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu li a:before,
          .sidebar-wrapper ul li a i,
          .page-wrapper .page-content,
          .sidebar-wrapper .sidebar-search input.search-menu,
          .sidebar-wrapper .sidebar-search .input-group-text,
          .sidebar-wrapper .sidebar-menu ul li a,
        
          #close-sidebar {
          -webkit-transition: all 0.3s ease;
          -moz-transition: all 0.3s ease;
          -ms-transition: all 0.3s ease;
          -o-transition: all 0.3s ease;
          transition: all 0.3s ease;
          }

          .sidebar-dropdown.active{

          }

          /* Adjust the sidebar when the screeen resize */
          @media only screen and (max-width: 767px) {

              .sidebar-wrapper{
                padding-top: 75px;
              }
          }
          /*----------------page-wrapper----------------*/

              .page-wrapper {
              height: 100vh;
              }

              .page-wrapper .theme {
              width: 40px;
              height: 40px;
              display: inline-block;
              border-radius: 4px;
              margin: 2px;
              }

              .page-wrapper .theme.chiller-theme {
              background: #1e2229;
              }

          /*----------------toggeled sidebar----------------*/

              .page-wrapper.toggled .sidebar-wrapper {
              left: 0px;
              }

              @media screen and (min-width: 768px) {
                .page-wrapper.toggled .page-content {
                    padding-left: 260px;
                }
              }

          
          /*----------------show sidebar button----------------*/
              /* #show-sidebar {
              position: fixed;
              left: 0;
              top: 10px;
              border-radius: 0 4px 4px 0px;
              width: 35px;
              transition-delay: 0.3s;
              } */
              /* .page-wrapper.toggled #show-sidebar {
              left: -40px;
              } */
          /*----------------sidebar-wrapper----------------*/

              .sidebar-wrapper {
              width: 260px;
              height: 100%;
              max-height: 100%;
              position: fixed;
              top: 0;
              left: -300px;
              z-index: 999;

              /* To make up for the added space of the fixed top navbar */
              
              }

              .sidebar-wrapper ul {
              list-style-type: none;
              padding: 0;
              margin: 0;
              }

              .sidebar-wrapper a {
              text-decoration: none;
              }

          /*----------------sidebar-content----------------*/

              .sidebar-content {
              max-height: calc(100% - 30px);
              height: calc(100% - 30px);
              overflow-y: auto;
              position: relative;
              }

              .sidebar-content.desktop {
              overflow-y: hidden;
              }

          /*--------------------sidebar-brand----------------------*/

              .sidebar-wrapper .sidebar-brand {
              padding: 10px 20px;
              display: flex;
              align-items: center;
              }

              .sidebar-wrapper .sidebar-brand > a {
              text-transform: uppercase;
              font-weight: bold;
              flex-grow: 1;
              text-align: center;
              padding-top: 10px;
              }

              .sidebar-wrapper .sidebar-brand #close-sidebar {
              cursor: pointer;
              font-size: 20px;
              }
          /*--------------------sidebar-header----------------------*/

              .sidebar-wrapper .sidebar-header {
              padding: 20px;
              overflow: hidden;
              }

              .sidebar-wrapper .sidebar-header .user-pic {
              float: left;
              width: 60px;
              padding: 2px;
              border-radius: 12px;
              margin-right: 15px;
              overflow: hidden;
              }

              .sidebar-wrapper .sidebar-header .user-pic img {
              object-fit: cover;
              height: 100%;
              width: 100%;
              }

              .sidebar-wrapper .sidebar-header .user-info {
              float: left;
              }

              .sidebar-wrapper .sidebar-header .user-info > span {
              display: block;
              }

              .sidebar-wrapper .sidebar-header .user-info .user-role {
              font-size: 12px;
              }

              .sidebar-wrapper .sidebar-header .user-info .user-status {
              font-size: 11px;
              margin-top: 4px;
              }

              .sidebar-wrapper .sidebar-header .user-info .user-status i {
              font-size: 8px;
              margin-right: 4px;
              color: #5cb85c;
              }

          /*-----------------------sidebar-search------------------------*/

              .sidebar-wrapper .sidebar-search > div {
              padding: 10px 20px;
              }

          /*----------------------sidebar-menu-------------------------*/

              .sidebar-wrapper .sidebar-menu {
              padding-bottom: 10px;
              }

              .sidebar-wrapper .sidebar-menu .header-menu span {
              font-weight: bold;
              font-size: 14px;
              padding: 15px 20px 5px 20px;
              display: inline-block;
              }

              .sidebar-wrapper .sidebar-menu ul li a {
              display: inline-block;
              width: 100%;
              text-decoration: none;
              position: relative;
              padding: 8px 30px 8px 20px;
              }

              .sidebar-wrapper .sidebar-menu ul li a i {
              margin-right: 10px;
              font-size: 12px;
              width: 30px;
              height: 30px;
              line-height: 30px;
              text-align: center;
              border-radius: 4px;
              }

              .sidebar-wrapper .sidebar-menu ul li a:hover > i::before {
              display: inline-block;
              animation: swing ease-in-out 0.5s 1 alternate;
              }

              .sidebar-wrapper .sidebar-menu .sidebar-dropdown > a:after {
              font-family: "Font Awesome 5 Free";
              font-weight: 900;
              /* content: "\f105"; */
              font-style: normal;
              display: inline-block;
              font-style: normal;
              font-variant: normal;
              text-rendering: auto;
              -webkit-font-smoothing: antialiased;
              -moz-osx-font-smoothing: grayscale;
              text-align: center;
              background: 0 0;
              position: absolute;
              right: 15px;
              top: 14px;
              }

              .sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu ul {
              padding: 5px 0;
              }

              .sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu li {
              padding-left: 25px;
              font-size: 13px;
              }

              .sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu li a:before {
              content: "\f111";
              font-family: "Font Awesome 5 Free";
              font-weight: 400;
              font-style: normal;
              display: inline-block;
              text-align: center;
              text-decoration: none;
              -webkit-font-smoothing: antialiased;
              -moz-osx-font-smoothing: grayscale;
              margin-right: 10px;
              font-size: 8px;
              }

              .sidebar-wrapper .sidebar-menu ul li a span.label,
              .sidebar-wrapper .sidebar-menu ul li a span.badge {
              float: right;
              margin-top: 8px;
              margin-left: 5px;
              }

              .sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu li a .badge,
              .sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu li a .label {
              float: right;
              margin-top: 0px;
              }

              .sidebar-wrapper .sidebar-menu .sidebar-submenu {
              display: none;
              }

              .sidebar-wrapper .sidebar-menu .sidebar-dropdown.active > a:after {
              transform: rotate(90deg);
              right: 17px;
              }

          /*--------------------------side-footer------------------------------*/

              .sidebar-footer {
              position: absolute;
              width: 100%;
              bottom: 0;
              display: flex;
              }

              .sidebar-footer > a {
              flex-grow: 1;
              text-align: center;
              height: 30px;
              line-height: 30px;
              position: relative;
              }

              .sidebar-footer > a .notification {
              position: absolute;
              top: 0;
              }

              .badge-sonar {
              display: inline-block;
              background: #980303;
              border-radius: 50%;
              height: 8px;
              width: 8px;
              position: absolute;
              top: 0;
              }

              .badge-sonar:after {
              content: "";
              position: absolute;
              top: 0;
              left: 0;
              border: 2px solid #980303;
              opacity: 0;
              border-radius: 50%;
              width: 100%;
              height: 100%;
              animation: sonar 1.5s infinite;
              }

          /*--------------------------page-content-----------------------------*/

              .page-wrapper .page-content {
              display: inline-block;
              width: 100%;
              padding-left: 0px;
              padding-top: 0px;   /*--------------------------20 DEFAULT----------------------------*/
              }

              .page-wrapper .page-content > div {
              padding: 20px 40px;
              }



              .page-wrapper .page-content {
              overflow-x: hidden;
              }

          /*------scroll bar---------------------*/

              ::-webkit-scrollbar {
              width: 5px;
              height: 7px;
              }
              ::-webkit-scrollbar-button {
              width: 0px;
              height: 0px;
              }
              ::-webkit-scrollbar-thumb {
              background: #525965;
              border: 0px none #ffffff;
              border-radius: 0px;
              }
              ::-webkit-scrollbar-thumb:hover {
              background: #525965;
              }
              ::-webkit-scrollbar-thumb:active {
              background: #525965;
              }
              ::-webkit-scrollbar-track {
              background: transparent;
              border: 0px none #ffffff;
              border-radius: 50px;
              }
              ::-webkit-scrollbar-track:hover {
              background: transparent;
              }
              ::-webkit-scrollbar-track:active {
              background: transparent;
              }
              ::-webkit-scrollbar-corner {
              background: transparent;
              }


          /*-----------------------------chiller-theme-------------------------------------------------*/

              .chiller-theme .sidebar-wrapper {
                  background: #31353D;
              }

              .chiller-theme .sidebar-wrapper .sidebar-header,
              .chiller-theme .sidebar-wrapper .sidebar-search,
              .chiller-theme .sidebar-wrapper .sidebar-menu {
                  border-top: 1px solid #3a3f48;
              }

              .chiller-theme .sidebar-wrapper .sidebar-search input.search-menu,
              .chiller-theme .sidebar-wrapper .sidebar-search .input-group-text {
                  border-color: transparent;
                  box-shadow: none;
              }

              .chiller-theme .sidebar-wrapper .sidebar-header .user-info .user-role,
              .chiller-theme .sidebar-wrapper .sidebar-header .user-info .user-status,
              .chiller-theme .sidebar-wrapper .sidebar-search input.search-menu,
              .chiller-theme .sidebar-wrapper .sidebar-search .input-group-text,
              .chiller-theme .sidebar-wrapper .sidebar-brand>a,
              .chiller-theme .sidebar-wrapper .sidebar-menu ul li a,
              .chiller-theme .sidebar-footer>a {
                  color: #818896;
              }

              .chiller-theme .sidebar-wrapper .sidebar-menu ul li:hover>a,
              .chiller-theme .sidebar-wrapper .sidebar-menu .sidebar-dropdown.active>a,
              .chiller-theme .sidebar-wrapper .sidebar-header .user-info,
              .chiller-theme .sidebar-wrapper .sidebar-brand>a:hover,
              .chiller-theme .sidebar-footer>a:hover i {
                  color: #b8bfce;
              }

              .page-wrapper.chiller-theme.toggled #close-sidebar {
                  color: #bdbdbd;
              }

              .page-wrapper.chiller-theme.toggled #close-sidebar:hover {
                  color: #ffffff;
              }

              .chiller-theme .sidebar-wrapper ul li:hover a i,
              .chiller-theme .sidebar-wrapper .sidebar-dropdown .sidebar-submenu li a:hover:before,
              .chiller-theme .sidebar-wrapper .sidebar-search input.search-menu:focus+span,
              .chiller-theme .sidebar-wrapper .sidebar-menu .sidebar-dropdown.active a i {
                  color: #ee4444;
                  text-shadow:#ee4444;
              }

              .chiller-theme .sidebar-wrapper .sidebar-menu ul li a i,
              .chiller-theme .sidebar-wrapper .sidebar-menu .sidebar-dropdown div,
              .chiller-theme .sidebar-wrapper .sidebar-search input.search-menu,
              .chiller-theme .sidebar-wrapper .sidebar-search .input-group-text {
                  background: #3a3f48;
              }

              .chiller-theme .sidebar-wrapper .sidebar-menu .header-menu span {
                  color: #6c7b88;
              }

              .chiller-theme .sidebar-footer {
                  background: #3a3f48;
                  box-shadow: 0px -1px 5px #282c33;
                  border-top: 1px solid #464a52;
              }

              .chiller-theme .sidebar-footer>a:first-child {
                  border-left: none;
              }

              .chiller-theme .sidebar-footer>a:last-child {
                  border-right: none;
              }

        
              /* Breadcrumb link */


        /* Breadcrumbs */
        .breadcrumbs_row{
            padding: 15px 30px;
            background: #fff;
            box-shadow: 1px 0 5px rgba(0,0,0,.1);
            margin-bottom: 15px;
        }

        .breadcrumbs_row .text-themecolor {
            color: #FD0302;
        }
        
        .breadcrumbs_row .breadcrumb {
            padding: 0;
            margin: 0;
            background: 0 0;
            font-size: 14px;
        }

        .breadcrumbs_row .breadcrumb-item+.breadcrumb-item {
            display: flex;
            align-items: center;
        }

        .breadcrumb_col ol li a{
            
            color: #FD0302;
            text-decoration: none;
        }

        /* Admin Cards Design */

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
            font-family: 'Roboto', 'serif-sans';
            font-size: 24px;
            font-weight: 400;
            color: black;
        }

        /* Fonts */
        .sidebar-nav-text{
            font-family: 'Roboto', sans-serif;
            font-weight: 300;
            font-size: 14px;
        }

        /* Card Footer Navigation Links Style */
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

        /* Form Label */
		.body-text-thicker{
			font-family: 'Roboto', sans-serif;
			font-weight: 500;
			font-size: 20px;
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

        /* Card Title - Registered Accounts etc */
		.card-heading{
			font-family: 'Montserrat', sans-serif;
			font-weight: 500;
			font-size: 24px;
            color: #FD0302;
		}

        /* Card Title - Admin settings*/
		.card-title{
			font-family: 'Montserrat', sans-serif;
			font-weight: 400;
			font-size: 18px;
		}

        .page-btn{
                color: white;
                background-color: #4b922d;
            }

        .page-btn:hover{
            color: white;
            background-color: #085D2A;
        }

        .admin_nav_links li a
        {
            color: #2b2b2b;
        }
        

        .admin_nav_links li a:hover
        {
            color: #FD0302;
        }

        .page-item.active .page-link{
            background-color: #4b922d;
            border-color: #4b922d;
        }

        .dataTables_paginate li a{
            color: #4b922d;
        }

        .dataTables_paginate li a:hover{
            color: #085D2A;
        }

    </style>

      
    @yield('styles')

    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  </head>
  <body>
      
    

    <div class="page-wrapper chiller-theme toggled">

        <nav id="sidebar" class="sidebar-wrapper">
          <div class="sidebar-content">
            <div class="sidebar-brand">
              <a href="/admin/dashboard">Administrator Panel</a>
              <div id="close-sidebar">
                <i class="fas fa-times"></i>
              </div>
            </div>
            <div class="sidebar-header">
              <div class="user-info">
                <span class="user-name">
                    <strong>{{Auth::user()->first_name. ' ' . Auth::user()->middle_initial. '. ' .Auth::user()->last_name}}</strong>
                </span>
                <span class="user-role">Administrator</span>
                <span class="user-status">
                  <i class="fa fa-circle"></i>
                  <span>Online</span>
                </span>
              </div>
            </div>
            <!-- sidebar-header  -->
            
            <div class="sidebar-menu">
              <ul>
                <li class="header-menu">
                  <span>Admin Pages</span>
                </li>
                <li class="{{ Route::is('admin.dashboard') ? 'active' : ' ' }} sidebar-dropdown">
                  <a href="/admin/dashboard">
                    <i class="fa fa-tachometer-alt"></i>
                    <span class="sidebar-nav-text">Dashboard</span>
                  </a>
                </li>
                <li class="{{ Route::is('admin.showSalesReport') || Route::is('admin.showSalesReportByDate') || Route::is('admin.showSalesReportByDateFormat') ? 'active' : ' ' }} sidebar-dropdown">
                    <a href="/admin/sales">
                    <i class="fas fa-chart-bar"></i>
                      <span class="sidebar-nav-text">Sales Reports</span>
                    </a>
                </li>
                <li class="{{ Route::is('admin.account') ? 'active' : ' ' }} sidebar-dropdown">
                  <a href="/admin/accounts">
                    <i class="fas fa-user-alt"></i>
                    <span class="sidebar-nav-text">Account Management</span>
                  </a>
                </li>
                <li class="{{ Route::is('admin.inventory') || Route::is('products.showLowOnStock') ? 'active' : ' ' }} sidebar-dropdown">
                  <a href="/admin/inventory">
                    <i class="fas fa-dolly-flatbed"></i>
                    <span class="sidebar-nav-text">Online Item Inventory</span>
                  </a>
                </li>
                <li class="{{Route::is('admin.showUserOrders') || Route::is('admin.showOrder') || Route::is('admin.showTotalSales') || Route::is('admin.showTodaySales') || Route::is('admin.showOrderAll') || Route::is('admin.showOrderOrdered') || Route::is('admin.showOrderShipped') || Route::is('admin.showOrderDelivered') || Route::is('admin.showOrderCanceled') ? 'active' : ' ' }} sidebar-dropdown">
                  <a href="/admin/orders">
                    <i class="fas fa-clipboard-list"></i>
                    <span class="sidebar-nav-text"> Order & Delivery</span>
                  </a>
                </li>
                <li class="{{ Route::is('admin.showAdminSettings')? 'active' : ' ' }} sidebar-dropdown">
                    <a href="/admin/settings">
                        <i class="fas fa-tools"></i>
                        <span class="sidebar-nav-text"> Administrator Settings</span>
                    </a>
                </li>
                
              </ul>
            </div>
            <!-- sidebar-menu  -->
          </div>
          <!-- sidebar-content  -->
        </nav>
        <!-- sidebar-wrapper  -->

        <main class="page-content">
          <div class="container-fluid p-0">

            {{-- Main Navbar --}}
            <nav class="navbar sticky-top navbar-expand-md bg-white shadow-sm top-nav py-3">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/store') }}">
                        {{-- {{ config('app.name', 'Laravel') }} --}}
                        <img src="/storage/logo/kh-logo.png" alt="Koop Hardware Logo" height="40">
                    </a>
                    
                    <button id="show-sidebar" type="button" class="btn btn-sm btn-light toggler_btn mr-4" href="#">
                        <i class="fas fa-tasks"></i></span>
                    </button>
                    
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <i class="fas fa-bars"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                            
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto  admin_nav_links">
                            <!-- Authentication Links -->
                            <li class="nav-item">
                                <a class="nav-link" href="/store">View Store</a>
                            </li>
                            
                            
                            @auth
                                @if (Auth::user()->user_type === 'admin')
                                
                                  <li class="nav-item dropdown">
                                      <a id="navbarDropdown"  class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                          {{ Auth::user()->first_name }}
                                      </a>

                                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                          <a class="dropdown-item" href="/admin/dashboard">
                                              {{ __('Admin Dashboard') }}
                                          </a>

                                          <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                              {{ __('Logout') }}
                                          </a>

                                          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                              @csrf
                                          </form>
                                      </div>
                                </li>
                                

                                @else
                                
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            {{ Auth::user()->name }}
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            
                                            <a class="dropdown-item" href="/user/dashboard">
                                                {{ __('User Dashboard') }}
                                            </a>
                                            
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                                
                                    
                                @endif
                                
                                
                            @else
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @endauth
                        </ul>
                    </div>
                </div>
            </nav>
              
            <div id="app">
                @include('inc.messages')
                <main class="container py-2">
                    @yield('content')
                </main>
            </div>
          
          </div>
        </main>
        <!-- page-content" -->
    </div>

    <script>
        jQuery(function ($) {

            $(".sidebar-dropdown > a").click(function() {
                $(".sidebar-submenu").slideUp(200);

                if ( $(this) .parent().hasClass("active")) 
                {
                    $(".sidebar-dropdown").removeClass("active");
                    $(this)
                    .parent()
                    .removeClass("active");
                } 
                else 
                {
                    $(".sidebar-dropdown").removeClass("active");
                    $(this)
                    .next(".sidebar-submenu")
                    .slideDown(200);
                    $(this)
                    .parent()
                    .addClass("active");
                }
            });

            $("#show-sidebar").click(function() {
                $(".page-wrapper").toggleClass("toggled");
            });
            
            $("#close-sidebar").click(function() {
                $(".page-wrapper").removeClass("toggled");
            });



        });
  </script>
  @yield('post-scripts')
  </body>
</html>
