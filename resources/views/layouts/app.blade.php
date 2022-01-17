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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      
        @yield('scripts')

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        {{-- Google Fonts --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        @yield('styles')
        
        {{-- Nav --}}
        <style>
            
            body{
                background-color: #F1F5FB;
            }
            
            .nav_links{
                text-decoration: none;
                color: #7F7F7F;
            }

            .nav_links:hover{
                text-decoration: none;
                color: #FD0302;
            }

            .nav_links.active{
                text-decoration: none;
                color: #FD0302;
                font-weight: 500;
            }
            
            .pages_nav_div .nav-item .nav-link{
                text-decoration: none;
                color: #000000;
            }

            .pages_nav_div .nav-item .nav-link:hover{
                text-decoration: none;
                color: #FD0302;
            }

            .pages_nav_div .nav-item .nav-link.active{
                text-decoration: none;
                color: #FD0302;
            }

            /* Breadcrumb link */
            .breadcrumb_col a{
                color: #FD0302;
                text-decoration: none;
            }

            /* Custom CSS */

            /* Product Name Links */
            .product-name-text{
                text-decoration: none;
                color: #000000;
                
                font-family: 'Roboto', sans-serif;
                font-weight: 400;
                font-size: 16px;
            }
            
            .product-name-text:hover{
                color: #FD0302;
                text-decoration: none;
            }

            .product-price-text{
                color: #000000;
                
                font-family: 'Roboto', sans-serif;
                font-weight: 400;
                font-size: 14px;
            }

            /* Text in Body */
            .body-text{
                font-family: 'Roboto', sans-serif;
                font-weight: 400;
                font-size:14px;
            }

            /* Text in Body Headings*/
            .heading-text{
                font-family: 'Montserrat', sans-serif;
                font-weight: 400;
                font-size: 18px;
            }

            .category-text{
                color: #FD0302;
                font-family: 'Roboto', sans-serif;
                font-weight: 400;
                font-size: 12px;
            }

            .nav-text{
                text-decoration: none;
                color: #000000;
                
                font-family: 'Roboto', sans-serif;
                font-weight: 300;
                font-size: 22px;
            }

            .nav-text.active{
                text-decoration: none;
                color: #000000;
                
                font-family: 'Roboto', sans-serif;
                font-weight: 400;
                font-size: 22px;
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

            .page-btn{
                color: white;
                background-color: #4b922d;
            }

            .page-btn:hover{
                color: white;
                background-color: #085D2A;
            }

            .page-item.active .page-link{
                background-color: #4b922d;
                border-color: #4b922d;
            }

            .page-item a{
                color: #4b922d;
            }

            .page-item a:hover{
                color: #085D2A;
            }

            /* Pagination Links */
            @media screen and ( max-width: 768px ){

                li.page-item {

                    display: none;
                }

                .page-item:first-child,
                .page-item:nth-child( 2 ),
                .page-item:nth-last-child( 3 ),
                .page-item:last-child,
                .page-item.active,
                .page-item.disabled {

                    display: block;
                }
            }
        </style>


        {{-- Icons --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="icon" href="/storage/logo/icon.png">
    </head>
    <body>
            
            {{-- 1st Navbar with Login and Register --}}
            <div class="container-fluid">
                <nav class="navbar navbar-expand-sm navbar-light bg-light py-0">
                    <div class="navbar-nav ml-auto register-nav">
                    </div>
                    
                    @auth
                        @if (Auth::user()->user_type === 'admin')
                                <a id="navbarDropdown" class="nav-link dropdown-toggle nav_links" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
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
                        @else
                                <a id="navbarDropdown" class="nav-link dropdown-toggle nav_links" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->first_name }}
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
                        @endif
                        
                        @else
                            @if (Route::has('login'))
                                <a class="nav-link nav_links {{ Route::is('login') ? 'active' : ' ' }}" href="{{ route('login') }}">{{ __('Login') }}</a>
                            @endif
                            @if (Route::has('register'))
                                <a class="nav-link nav_links {{ Route::is('register') ? 'active' : ' ' }}" href="{{ route('register') }}">{{ __('Register') }}</a>
                            @endif
                    @endauth
                </nav> 
            </div>
            
            {{-- Navbar for Logo --}}
            <nav class="navbar py-4 navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/store') }}">
                        <img src="/storage/logo/kh-logo.png" alt="Koop Hardware Logo" height="40">
                    </a>
                    
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse " id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">

                        </ul>
                        <div class="pages_nav_div">
                            <!-- Right Side Of Navbar -->
                            <ul class="navbar-nav ml-auto">
                                <!-- Authentication Links -->

                                <li class="nav-item">
                                    <a class="nav-link my-auto nav-text {{ Route::is('products.sortNameAtoZ') || Route::is('products.sortPriceHighToLow') || Route::is('products.sortPriceLowToHigh') || Route::is('products.sortNameZToA') ? 'active' : ' ' }}" href="/store">{{ __('Store') }}</a>
                                </li>
                                @if (!Auth::user())
                                    @elseif ((Auth::user()->user_type === 'admin'))
                                    @else
                                    <li class="nav-item ">
                                        <a class="nav-link nav-text {{ Route::is('pages.cart') || Route::is('pages.checkout') ? 'active' : ' ' }}" href="/cart">{{ __('Cart') }}</a>
                                    </li>
                                @endif
                                
                            </ul>
                        </div>
                        
                    </div>
                </div>
            </nav>  
        <div id="app">
            @include('inc.messages')
            <main class="container py-4">
                @yield('content')
            </main>
        </div>
        
        

        @yield('post-scripts')
    </body>
</html>
