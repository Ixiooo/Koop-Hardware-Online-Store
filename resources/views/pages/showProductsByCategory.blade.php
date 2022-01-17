@extends('layouts.app')

@section('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"/>

@endsection

@section('styles')
    <style>

        .product{
            margin-top: 5px;
            margin-bottom: 5px;

        }

        .product .product_thumbnail figure{
            height:100% ;
            width:100%  ;
            display: inline-block;
            overflow: hidden;
        }

        .productimg{
            max-width:100%;
            max-height:100%;
            object-fit: cover;
            
        }

        .product_info{
            display: block;
            text-align: center;
            padding-top: 5px;
        }

        .product_list{
            display: inline-block !important;
            padding: 0;
        }

        .product_list li{
            display: block !important;
            list-style: none;
            border: none;
            padding: 0;
        }

        .category_div{
            display: inline-block;
            width: 100%;
            text-align: left;
        }

        .category_title{
            font-size: 18px;
            color: #222222;
            font-weight: 700;
            margin: 0;
            width: 100%;
            text-align: left;
            border-bottom: 1px solid #e6e6e6;
            float: left;
            line-height: 1.1;
            box-sizing: border-box;
        }

        .category_div ul{
            margin-left: 0;
            padding-left: 0;
        }

        .category_div ul li{
            
            display:block;
            width: 100%;
            list-style: none;
            color: black;
            text-align: left;
            
        }

        /* Left Side Category Style */
        .sidebar-filter a{
            display:block;
            width: 100%;
            list-style: none;
            color: black;
            text-align: left;
            text-decoration: none;
            font-size: 16px;
        }

        .sidebar-filter a:hover{
            display:block;
            width: 100%;
            list-style: none;
            color: #FD0302;
            text-align: left;
            text-decoration: none;
        }

        .sidebar-filter a.active{
            display:block;
            width: 100%;
            list-style: none;
            color: #FD0302;
            text-align: left;
            text-decoration: none;
        }


        .list-category{

            text-align: left;
        }

        .category_div ul li a{
            display:block;
            width: 100%;
            list-style: none;
            color: black;
            
            text-align: left;
        }

        .pagination {
            justify-content: right;
        }

        /* Font Awesome Icons */
        .icon{
                color: #16AFED;
            
        }

        /* Search Button Alignment */
        .btn-group .btn {
            border-radius: 0;
            margin-left: -1px;
        }
        .btn-group .btn:last-child {
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
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

         /* Product Name Links */
         .product-name{
            text-decoration: none;
            color: #000000;
        }

        .product_info a:hover{
            text-decoration: none;
            color: #FD0302;
        }

    </style>
@endsection

@section('content')
        {{-- Breadcrumb --}}
        <div class="row justify-content-start ">
            <div class="col breadcrumb_col">
                <nav style="" aria-label="breadcrumb" class="pl-0 py-0">
                    <ol class="breadcrumb pb-2 mb-2">
                    <li class="breadcrumb-item"><a href="/store">Home</a></li>
                    <li class="breadcrumb-item"><a href="/store">Store</a></li>
                    <li id="breadcrumb_active" class="breadcrumb-item active" aria-current="page">{{$current_category}}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            
            {{-- Left Side for Categories --}}
            <div class="col-lg-3 col-md-4 col-sm-4 col-12 order-2 order-sm-1 sidemenu">

                <div class="row pt-3">
                    <div class="col">
                        <h5 class="text-uppercase font-weight-bold category_title pb-2">ITEM CATEGORIES</h5>
                    </div>
                </div>

                <div class="row pt-1">
                    <div class="col-12 sidebar-filter text-left">
                        @if (count($product_categories) > 0)
                            <div class="mt-1 mb-1 pl-2">
                                <a href="/store" class="cate-link category-text {{ Route::is('products.sortNameAtoZ') ? 'active' : ' ' }}">All</a>
                            </div>
                            @foreach ($product_categories as $product_category )
                                <div class="mt-1 mb-1 pl-2">
                                    <a href="{{ route('products.categoryAll', ['product_category' => $product_category->product_category]) }}" class="cate-link category-text {{ $current_category == $product_category->product_category ? 'active' : ' '}}">{{$product_category->product_category}}</a>
                                </div>
                            @endforeach
                            @else
                        @endif
                        
                    </div>
                </div>
                
            </div>

            {{-- Right Side for Products --}}
            <div class="col-lg-9 col-md-8 col-sm-8 col-12 order-1 order-sm-2">
            
                {{-- Search Bar and Sort --}}
                <div class="row mt-2 justify-content-between">

                    {{-- Searchbar --}}
                    <div class="col-lg-6 col-12 mb-3">
                        <div class="row">
                            <div class="col-8 col-sm-9 pr-0 pr-sm-1  col-md-12 ">
                                {!! Form::open(['route' => 'products.showSearch', 'method' => 'GET','enctype' => 'multipart/form-data']) !!}
                                    
                                    <div class="input-group" id="adv-search">
                                        <input type="text" name="search" id="search" class="form-control body-text" placeholder="Search Products" />
                                        <div class="input-group-btn">
                                            <div class="btn-group" role="group">
                                                <button type="submit" class="btn page-btn"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                            <div class="col-4 col-sm-3 pl-0 d-block d-md-none  text-right cart-div">
                                <a href="/cart" class="my-auto btn page-btn">
                                    <span class="cart-text"> Cart <i class="fas fa-shopping-cart"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Dropdown --}}
                    <div class="col-lg-6 col-12 mb-3 text-right">
                        <div class="d-flex justify-content-end">
                            <div  class="dropdown mr-2">					
                                Sort:
                                <button id="sort_category_text" class="btn page-btn dropdown-toggle body-text" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @if ($sortedBy == 'productNameAsc'  || $sortedBy == 'productNameDesc' )
                                        Name
                                    @elseif ($sortedBy == 'productPriceAsc'  || $sortedBy == 'productPriceDesc' )
                                        Price
                                    @endif

                                </button>
                                <ul  id="sort_category" class="dropdown-menu body-text" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="#"> Name </a></li>
                                    <li><a class="dropdown-item" href="#"> Price </a></li>
                                </ul>
                            </div>
                            <div class="dropdown">	
                                <button id="sort_options_text"  class="btn page-btn dropdown-toggle body-text" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @if ($sortedBy == 'productNameAsc')A to Z
                                    @elseif ($sortedBy == 'productNameDesc')Z to A
                                    @elseif ($sortedBy == 'productPriceAsc')Low to High
                                    @elseif ($sortedBy == 'productPriceDesc')High to Low
                                    @endif
                                </button>
                                <ul id="sort_options" class="dropdown-menu body-text" aria-labelledby="dropdownMenuButton">
                                    @if ($sortedBy == 'productNameAsc'  || $sortedBy == 'productNameDesc' )
                                        <li><a class="dropdown-item" href="{{ route('products.categorySort', ['product_category' => $current_category, 'sortBy' =>'product_name','order' =>'asc']) }}" >A to Z</a></li>
                                        <li><a class="dropdown-item" href="{{ route('products.categorySort', ['product_category' => $current_category, 'sortBy' =>'product_name','order' =>'desc']) }}" >Z to A</a></li>
                                    @elseif ($sortedBy == 'productPriceAsc'  || $sortedBy == 'productPriceDesc' )
                                        <li><a class="dropdown-item" href="{{ route('products.categorySort', ['product_category' => $current_category, 'sortBy' =>'product_price','order' =>'asc']) }}">Low to High</a> </li> 
                                        <li><a class="dropdown-item" href="{{ route('products.categorySort', ['product_category' => $current_category, 'sortBy' =>'product_price','order' =>'desc']) }}">High to Low</a></li>
                                    @endif
                                        
                                </ul>
                            </div>
                        </div>
                        
                    </div>

                </div>

                {{-- Category Info --}}
                <div class="row pt-2">
                    <div class="col-12">
                        <hgroup class="">
                            <h2 class="lead heading-text"><strong></strong> Showing Products Under the Category <strong style="color: #4b922d;">{{$current_category}}</strong></h2>								
                        </hgroup>                    
                    </div>
                </div>

                {{-- Products Display --}}
                <div class="row justify-content-start">
                    @if (count($products)> 0 )
                        @foreach ($products as $product )
                        <div class="col-lg-3 col-md-6 col-sm-6 col-6 text-center d-flex align-items-stretch">
                            <div class="card product">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="product_thumbnail pt-4 px-3">
                                            <a href="/products/{{$product->id}}" title="{{$product->product_name}} ">
                                                <figure><img src="/storage/product_image/{{$product->product_image}}" alt="" class="productimg "></figure>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body product_info d-flex flex-column">
                                    <div class="row pb-3">
                                        <div class="col-md-12">
                                            <a href="/products/{{$product->id}}"  class="product-name-text"><span>{{$product->product_name}} </span></a>
                                        </div>
                                    </div>
    
                                    <div class="row pb-2 mt-auto">
                                        <div class="col-md-12">
                                            <div class="wrap-price"><span class="product-price-text">₱ {{number_format($product->product_price, 2)}}</span></div>
                                        </div>
                                    </div>

                                    <div class="row mt-auto">
                                        <div class="col-md-12">
                                            @if (!Auth::user())
                                                {!! Form::open(['route' => 'user.addToCart', 'method' => 'POST','enctype' => 'multipart/form-data']) !!}
                                                @csrf
                                                {!! Form::hidden('product_id', $product->id) !!}
                                                {!! Form::hidden('product_name', $product->product_name) !!}
                                                {!! Form::hidden('product_price', $product->product_price) !!}
                                                {{-- {{  Form::submit('Add To Cart', ['class' => 'btn page-btn my-auto']) }} --}}
                                                <button class="btn page-btn my-auto" type="submit">
                                                    <i class="fas fa-cart-plus"></i><span class="body-text"> Add to Cart</span>
                                                </button>
                                                {!! Form::close() !!}    
                                            @elseif ((Auth::user()->user_type === 'user'))
                                                {!! Form::open(['route' => 'user.addToCart', 'method' => 'POST','enctype' => 'multipart/form-data']) !!}
                                                @csrf
                                                {!! Form::hidden('product_id', $product->id) !!}
                                                {!! Form::hidden('product_name', $product->product_name) !!}
                                                {!! Form::hidden('product_price', $product->product_price) !!}
                                                {{-- {{  Form::submit('Add To Cart', ['class' => 'btn page-btn my-auto']) }} --}}
                                                <button class="btn page-btn my-auto" type="submit">
                                                    <i class="fas fa-cart-plus"></i><span class="body-text"> Add to Cart</span>
                                                </button>
                                                {!! Form::close() !!}    
                                            @else
                                            @endif
                                        </div>
                                    </div>
                                </div>                               
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="col-md-12 text-center">
                            <div class="error-template">
                                <h2>
                                    No Products Found
                                </h2>

                                <div class="error-details">
                                    Sorry, it seems like there is no product listed under this category yet
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Pagination at the Bottom --}}
                <div class="row mt-2">
                    <div class="col">
                    </div>
                    <div class="col">
                            {{ $products->links('pagination::bootstrap-4') }}
                    </div>  
                </div>
            </div>
        </div>
    
    
@endsection

@section('post-scripts')

    <script>

        function toggle_second_dropdown()
        {
            $('#sort_category li').on('click', function(e){
                e.preventDefault();
                document.getElementById("sort_category_text").innerHTML = $(this).text();

                if(document.getElementById("sort_category_text").innerHTML === ' Name ')
                {
                    document.getElementById("sort_options_text").innerHTML = ' A to Z ';
                    $('#sort_options').html(`
                                                <li><a class="dropdown-item" href="{{ route('products.categorySort', ['product_category' => $current_category, 'sortBy' =>'product_name','order' =>'asc']) }}" >A to Z</a></li>
                                                <li><a class="dropdown-item" href="{{ route('products.categorySort', ['product_category' => $current_category, 'sortBy' =>'product_name','order' =>'desc']) }}" >Z to A</a></li>
                                            `);
                }
                else if(document.getElementById("sort_category_text").innerHTML === ' Price ')
                {
                    document.getElementById("sort_options_text").innerHTML = ' Low to High ';
                    $('#sort_options').html(`
                                                <li><a class="dropdown-item" href="{{ route('products.categorySort', ['product_category' => $current_category, 'sortBy' =>'product_price','order' =>'asc']) }}">Low to High</a> </li> 
                                                <li><a class="dropdown-item" href="{{ route('products.categorySort', ['product_category' => $current_category, 'sortBy' =>'product_price','order' =>'desc']) }}">High to Low</a></li>
                                            `);
                }
            });
        }


        $(document).ready(function(){

            toggle_second_dropdown();
        });
    </script>

@endsection