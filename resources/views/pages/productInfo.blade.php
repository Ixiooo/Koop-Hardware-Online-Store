@extends('layouts.app')

@section('scripts')

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"/>

@endsection

@section('styles')
    <style>

        /* Product name*/
        .product-name-heading{
            font-family: 'Montserrat', sans-serif;
            font-weight: 500;
            font-size: 28px;
        }

        /* Product Category*/
        .product-category-heading{
            font-family: 'Montserrat', sans-serif;
            font-weight: 400;
            font-size: 12px;
        }

        /* Product description*/
        .product-description-heading{
            font-family: 'Montserrat', sans-serif;
            font-weight: 500;
            font-size: 18px;
        }

        .product-description-text{
            font-family: 'Roboto', sans-serif;
            font-weight: 300;
            font-size: 16px;
        }

        /* Price text in product info */
        .price-text{
            font-family: 'Roboto', sans-serif;
            font-weight: 400;
            font-size:24px;
        }

        /* Text in Body */
        .body-text{
            font-family: 'Roboto', sans-serif;
            font-weight: 400;
            font-size:14px;
        }

        /* Products You Might Like */
        .product-suggestions-heading{
            font-family: 'Montserrat', sans-serif;
            font-weight: 500;
            font-size: 22px;
        }

        /* Product Name Links */
        .product-name-text{
            text-decoration: none;
            color: #000000;
            
            font-family: 'Roboto', sans-serif;
            font-weight: 400;
            font-size: 16px;
        }
        
        .product-name-text:hover{
            text-decoration: none;
        }

        .product-price-text{
            color: #000000;
            
            font-family: 'Roboto', sans-serif;
            font-weight: 400;
            font-size: 14px;
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
                    <li id="breadcrumb_active" class="breadcrumb-item active" aria-current="page">Product Details</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Product Details Card --}}
    <div class="card mt-3">
        <div class="card-body">
            <a style="text-decoration: none; color: #FD0302;" class="my-auto body-text" href="{{url()->previous()}}"> <i style="vertical-align: middle;" class="fas fa-long-arrow-alt-left fa-2x"></i>   Back to Store</a>
            
            <div class="row">
                <div style="justify-content: center;" class="col-lg-5 col-md-5 col-sm-6 d-flex flex-wrap align-items-center">
                    <figure><img style="width: 100%;" src="/storage/product_image_hd/{{$product->product_image}}" alt="" class="productimg img-responsive" id="previous_product_image"></figure> 
                </div>
                <div class="col-lg-7 col-md-7 col-sm-6">
                    <h2 class="mt-2 product-name-heading">{{$product->product_name}}</h2>
                    <h6 class="card-subtitle product-category-heading">Category: {{$product->product_category}}</h6>
                    <hr>
                    <h4 class="mt-2 product-description-heading">Product Description</h4>
                    <p class="product-description-text" style="white-space: pre-wrap;">{{$product->product_description}}</p>
                    <hr>
                    <div class="row">
                        <div class="col my-auto">
                            <h2 class="price-text">
                                ₱ {{number_format($product->product_price, 2)}}
                            </h2>
                        </div>
                        <div class="col my-auto text-right">
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
    </div>

    {{-- Suggestions Card --}}
    <div class="card mt-3">
        <div class="card-body">
            <h4 class="product-suggestions-heading">Products You Might Like</h4>
            <div class="row mt-3 justify-content-start">
                @if (count($suggestions)> 0 )
                    @foreach ($suggestions as $suggestion )
                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 text-center d-flex align-items-stretch">
                        <div class="card product mb-2">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="product_thumbnail pt-4 px-3">
                                        <a href="/products/{{$suggestion->id}}" title="{{$suggestion->product_name}} ">
                                            <figure><img style="width: 100%" src="/storage/product_image/{{$suggestion->product_image}}" alt="" class="productimg "></figure>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body product_info d-flex flex-column">
                                <div class="row pb-3">
                                    <div class="col-md-12">
                                        <a href="/products/{{$suggestion->id}}"  class="product-name-text"><span>{{$suggestion->product_name}} </span></a>
                                    </div>
                                </div>

                                <div class="row pb-2 mt-auto">
                                    <div class="col-md-12">
                                        <div class="wrap-price"><span class="product-price-text">₱ {{number_format($suggestion->product_price, 2)}}</span></div>
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
                @endif
            </div>
        </div>
    </div>
@endsection

@section('post-scripts')

    <script>
        
    </script>

@endsection