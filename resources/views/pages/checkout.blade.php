@extends('layouts.app')

@section('scripts')

@endsection

@section('styles')
    <style>

    
    /* Links */
    
    .desc a, .desc dd a{
        text-decoration: none;
        color: #353535;
    }

    .desc a:hover .desc dd a:hover{
        color: #FD0302;
        text-decoration: none;
        /* color: #0275d8; */
    }

    .card-footer{
        background-color: #bcd9ea;
    }

    .card-header{
        background-color: #4b922d;
        color: white;
    }

    /* Text in Body */
    .body-text{
        font-family: 'Roboto', sans-serif;
        font-weight: 400;
        font-size:14px;
    }

    .item-table-header{
        font-family: 'Roboto', sans-serif;
        font-weight: 500;
        font-size: 16px;
    }

    .item-table-name{
        font-family: 'Roboto', sans-serif;
        font-weight: 400;
        font-size: 20px;
    }

    .item-table-text{
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
                <li class="breadcrumb-item"><a href="/cart">Cart</a></li>
                <li id="breadcrumb_active" class="breadcrumb-item active" aria-current="page">Checkout</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row pt-3">

        {{-- Checkout Details Left Side --}}
        <div class="col-md-9 mb-3 order-2 order-md-1">
            <div class="card">
                <div class="card-header">
                    <span class="float-right my-auto">(<strong>{{Cart::instance('cart')->content()->count()}}</strong>) items</span>
                    <h5 class="my-auto">Checkout Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table shoping-cart-table">
                                    <thead class="text-center">
                                        <tr class="">
                                            <th class="item-table-header">Product Image</th>
                                            <th class="item-table-header">Name</th>
                                            <th class="item-table-header">Unit Price</th>
                                            <th class="item-table-header">Quantity</th>
                                            <th class="item-table-header">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
        
                                    @if (Cart::instance('cart')->count()>0)
                                        @foreach (Cart::instance('cart')->content() as $item)
                                        @if ($item->model->product_stock == 0)
                        
                                        @else
                                            <tr>
                                                <td>
                                                    <a href="/products/{{$item->model->id}}">
                                                        <img width="80" class="productimg"src="/storage/product_image/{{$item->model->product_image}}">
                                                    </a>
                                                </td>
                                                <td class="desc">
                                                    <h3 class="item-table-name">
                                                        <a href="/products/{{$item->model->id}}" class="text-navy">
                                                            {{$item->model->product_name}}
                                                        </a>
                                                    </h3>
                                                    <dl class="small m-b-none desc">
                                                        <dt>Category</dt>
                                                        <dd>
                                                            <a href="/category/{{$item->model->product_category}}">
                                                                {{$item->model->product_category}}
                                                            </a>
                                                        </dd>
                                                    </dl>
                                                </td>
                
                                                <td class="item-table-text">
                                                    ₱ {{$item->model->product_price}}
                                                </td>
                                                <td class="item-table-text">
                                                    <p>{{$item->qty}}</p>
                                                </td>
                                                <td>
                                                    <h6 class="item-table-text">
                                                        ₱ {{number_format(($item->model->product_price) * ($item->qty),2)}}
                                                    </h6>
                                                </td>
                                            </tr>
                                        @endif
                                        @endforeach
                                    @endif
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="col">
                            <a href="/cart" class="btn page-btn float-left"><i class="fa fa-arrow-left"></i> Back to Cart</a>
                        </div>
                        <div class="col">
                            <a href="/cart/checkout/placeOrder" class="btn page-btn float-right"><i class="fa fa fa-shopping-cart"></i> Checkout</a>
                        </div>
                    </div>
                </div>
                
            </div>

        </div>

        {{--Right Side --}}
        <div class="col-md-3 order-1 order-md-2">
            <div class="row">

                {{--Shipping Info --}}
                <div class="col-12">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5>Shipping Information</h5>
                        </div>
                        <div class="card-body text-center">
                            <span class="small">
                                <h6 class="body-text">{{$current_user->first_name.' '.$current_user->middle_initial.'. '.$current_user->last_name}}</h3>
                                
                                <h6 class="body-text">{{$current_user->email}}</h3>
                                
                                <h6 class="body-text">{{'Brgy. '.$current_user->barangay.', '.$current_user->city.' City. ' .$current_user->address_notes}}</h3>
                                
                                <h6 class="body-text">{{$current_user->mobile}}</h3>
                            </span>
                        </div>
                    </div>
                </div>
                
                {{-- Cart Summary --}}
                <div class="col-12">
                    <div class="card mt-3 mb-3">
                        <div class="card-header text-center">
                            <h5>Cart Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <p class="body-text">Cash on Delivery </p>
                                    <hr>
                                    <p class="body-text">Total: ₱ <b id="total" class="index">{{Cart::subtotal()}}</p>
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
    <script>

        function setup_ajax()
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }

        $(document).ready(function(){
            setup_ajax();
        });
    </script>
@endsection