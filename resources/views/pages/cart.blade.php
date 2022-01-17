@extends('layouts.app')

@section('scripts')

@endsection

@section('styles')
<style>

    .productimg{
        width: 100%;
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

    /* Links */
    
    .product_name a{
        text-decoration: none;
        color: #353535;
    }

    .product_name a:hover{
        text-decoration: none;
        color: #FD0302;
    }

    .back_link{
        color: white;
    }

    .back_link:hover{
        color: #cecece;
        text-decoration: none;
    }

    /* Font Awesome Icons */
    .icon{
        color: #ffffff;
    }

    /* Plus and Minus Btns */
    .btn-plus{
        margin-left: -4px;
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
    }

    .btn-minus{
        margin-right: -4px;
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
    }

    /* Text in Body */
    .body-text{
        font-family: 'Roboto', sans-serif;
        font-weight: 400;
        font-size:14px;
    }

    /* Text in Body Headings*/
    .cart-heading-name{
        font-family: 'Roboto', sans-serif;
        font-weight: 400;
        font-size: 18px;
    }

    .cart-heading-text{
        font-family: 'Montserrat', sans-serif;
        font-weight: 500;
        font-size: 24px;
    }

    .cart-text-price{
        font-family: 'Roboto', sans-serif;
        font-weight: 300;
        font-size: 16px;
    }
    
    .card-header{
        background-color: #4b922d;
        color: white;
    }

    .cart-total-price{
        font-family: 'Roboto', sans-serif;
        font-weight: 400;
        font-size:20px;
    }

    .cart-item-price{
        font-family: 'Roboto', sans-serif;
        font-weight: 400;
        font-size:20px;
    }

</style>
@endsection

@section('content')
    @if (Session::has('success_message'))
        <div class="alert alert-success">
            <strong> Success </strong> {{Session::get('success_message')}}
        </div>
    @endif
    
    <div id="alert_message">

    </div>
    
    {{-- Breadcrumb --}}
    <div class="row justify-content-start ">
        <div class="col breadcrumb_col">
            <nav style="" aria-label="breadcrumb" class="pl-0 py-0">
                <ol class="breadcrumb pb-2 mb-2">
                <li class="breadcrumb-item"><a href="/store">Home</a></li>
                <li id="breadcrumb_active" class="breadcrumb-item active" aria-current="page">Cart</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Cart Content --}}
    <div class="card mt-3">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <a class="my-auto back_link body-text" href="/store"> <i style="vertical-align: middle;" class="fas fa-long-arrow-alt-left fa-2x"></i>   Back to Store</a>
                </div>
                <div class="col d-flex justify-content-end align-items-center">
                    <span class="cart-heading-text">My Cart</span><i style="vertical-align: middle;" class="fas fa-shopping-cart fa-2x icon"></i>
                </div>
            </div>
        </div>
        <div class="card-body">
           
            @if (Cart::instance('cart')->count()>0)
                @foreach (Cart::instance('cart')->content() as $item)
                    @if ($item->model->product_stock == 0)
                        
                    @else
                    <div class="row my-3 py-2 cart_item">
                        {{-- Product Image --}}
                        <div class="col-sm-2 col-12 order-2 order-md-1 d-flex align-items-center">
                            <a href="/products/{{$item->model->id}}">
                                <img class="productimg"src="/storage/product_image_hd/{{$item->model->product_image}}">
                            </a>
                        </div>
                        {{-- Product Name --}}
                        <div class="col-sm-4 col-12 order-1 pt-2 order-md-2">
                            <h4 class="product_name cart-heading-name"><strong>
                                <a href="/products/{{$item->model->id}}">{{$item->model->product_name}}</a></strong>
                            </h4>
                            <h5 class="product_name">
                                <a class="" href="/category/{{$item->model->product_category}}">
                                    <small>Category: {{$item->model->product_category}}</small>
                                </a> 
                                <br>
                                <small class="">Stock: <span id="item_stock" class="item_stock" data-stock_cart_id="{{$item->rowId}}">{{$item->model->product_stock}}</span></small>
                            </h5>
                        </div>
                        {{-- Price and Buttons --}}
                        <div class="col-sm-6 col-12 order-3 order-md-3 my-auto">
                            {{-- Product Price --}}
                            <div class="row pt-2">
                                <div class="col-4 text-center md-text-right d-flex align-items-center justify-content-end">
                                    <h6 class="my-auto cart-text-price"><strong>₱ {{number_format($item->model->product_price,2)}} <span class="text-muted">x</span></strong></h6>
                                </div>
                                {{-- Buttons --}}
                                <div class="col-6 col-sm-8 col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <button type="button" id="decrease_btn" class="btn page-btn btn-minus" data-cart_id="{{$item->rowId}}">
                                                <span><i class="fas fa-minus"></i></span>
                                            </button>
                                        </span>
                                        <input type="number" min="1" name="qty_field" id="qty_field" class="form-control input-number body-text" data-quantity_cart_id="{{$item->rowId}}" value="{{$item->qty}}">
                                        <span class="input-group-btn">
                                            <button type="button" id="increase_btn" class="btn page-btn btn-plus" data-cart_id="{{$item->rowId}}">
                                                <span> <i class="fas fa-plus"></i></span>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-2 col-sm-10 col-md-2 ">
                                    {!! Form::open(['route'=>['user.removeFromCart'], 'method' => 'POST']) !!}
                                    {!! Form::hidden('rowId', $item->rowId, array('id' => 'rowId')) !!}
                                    {!! Form::button('<i class="far fa-trash-alt"></i>', ['type'=>'submit','class'=>'btn page-btn float-right mr-2' ]) !!}
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    @endif
                @endforeach
                
                <div class="row text-center">
                    <div class="col-md-9 col-12 pt-2 d-flex justify-content-end">
                        <h4 id="subtotal_text" class="text-right my-auto cart-total-price">Total ₱ <strong>{{Cart::instance('cart')->subtotal()}}</strong></h4>
                    </div>
                    <div class="col-md-3 col-12 pt-2">
                        <a style="text-decoration: none" href ="/cart/checkout" >
                            <button type="button" id="checkout_btn" class="btn page-btn btn-block my-auto body-text">
                                Checkout
                            </button>
                        </a>
                    </div>
                </div>
        </div>
        
        @else
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="error-template">
                            <h2>
                                No Products In Cart
                            </h2>
    
                            <div class="error-details">
                                It seems like there are no products in your cart
                            </div>
                            <div class="error-actions">
                                <a href="/store" class="btn page-btn btn-lg">
                                    <i class="fas fa-shopping-cart"></i>
                                    Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>   
                </div>
            @endif
    </div>
    

@endsection

@section('post-scripts')
    <script>

        var isChecking = false;

        function setup_ajax()
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }

        function updateQty()
        {
            
            // Click Increase Btn
            $('body').on('click', '#increase_btn', function () {
                var cartID = $(this).data('cart_id');

                $.ajax({
                    type : 'post',
                    url : '/increaseItemQty',
                    async : false,
                    data : {cartID:cartID},
                    success : function(data)
                    {
                        $('#subtotal_text').html(`Total ₱ <strong>`+data.subtotal+`</strong>`);
                        $("body").find('[data-quantity_cart_id='+cartID+']').val(parseInt(data.new_quantity));
                        check_quantity();
                    },
                    error:function(data)
                    {
                        errormsg = JSON.stringify(data);
                        console.log(errormsg);
                        alert(errormsg);
                    }
                });

                
                var max_stock = parseInt($("body").find('[data-stock_cart_id='+cartID+']').text());
                var current_quantity = parseInt( $("body").find('[data-quantity_cart_id='+cartID+']').val());

                if(current_quantity == max_stock)
                {
                    $("body").find('.btn-plus[data-cart_id='+cartID+']').prop('disabled', true);
                }

            });
        
            // Click Decrease Btn
            $('body').on('click', '#decrease_btn', function () {
                var cartID = $(this).data('cart_id');
                
                $.ajax({
                    type : 'post',
                    async: false,
                    url : '/decreaseItemQty',
                    data : {cartID:cartID},
                    success : function(data)
                    {
                        $('#subtotal_text').html(`Total ₱ <strong>`+data.subtotal+`</strong>`);
                        $("body").find('[data-quantity_cart_id='+cartID+']').val(parseInt(data.new_quantity));
                        check_quantity();

                },
                    error:function(data)
                    {
                        errormsg = JSON.stringify(data);
                        console.log(errormsg);
                        alert(errormsg);
                    }
                });
                var max_stock = parseInt($("body").find('[data-stock_cart_id='+cartID+']').text());
                var current_quantity = parseInt( $("body").find('[data-quantity_cart_id='+cartID+']').val());

                if(current_quantity == max_stock)
                {
                    $("body").find('.btn-plus[data-cart_id='+cartID+']').prop('disabled', true);
                }
                else
                {
                    $("body").find('.btn-plus[data-cart_id='+cartID+']').prop('disabled', false);
                }
            });

            // Type Quantity
            $('body').on('keyup keydown change', '#qty_field', function () {
                var cartID = $(this).data('quantity_cart_id');
                var qty = $(this).val();
                
                var max_stock = parseInt($("body").find('[data-stock_cart_id='+cartID+']').text());

                check_quantity();
    
                if(qty == 0 || qty =='')
                {
                    $('#alert_message').html
                    (
                        `<div class="alert alert-danger alert-dismissible fade show text-center">
                            <strong> Error, </strong> Item Quantity must not be empty
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>`
                    );
                    document.getElementById("checkout_btn").disabled = true;
                }
                else if(qty > max_stock)
                {
                    $('#alert_message').html
                    (
                        `<div class="alert alert-danger alert-dismissible fade show text-center">
                            <strong> Error, </strong> Quantity Exceeds the Maximum Stock Available
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>`
                    );
                    document.getElementById("checkout_btn").disabled = true;
                }
                else
                {
                    $('#alert_message').html(``);
                    $.ajax({
                        type : 'post',
                        url : '/setNumItemQty',
                        async : false,
                        data : {cartID:cartID, qty:qty},
                        success : function(data)
                        {
                            $('#subtotal_text').html(`Total ₱ <strong>`+data.subtotal+`</strong>`);
                            $("body").find('[data-quantity_cart_id='+cartID+']').val(parseInt(data.new_quantity));

                        },
                        error:function(data)
                        {
                            errormsg = JSON.stringify(data);
                            console.log(errormsg);
                            alert(errormsg);
                        }
                    });
                    document.getElementById("checkout_btn").disabled = false;
                }

            });
            
        }

        function check_quantity()
        {
            $('input.input-number[type="number"]').each(function() {
                if($(this).val() == 1)
                {
                    $(this).parents('.input-group').find('.btn-minus').prop('disabled', true);
                }
                else
                {
                    $(this).parents('.input-group').find('.btn-minus').prop('disabled', false);
                }
            });
        }

        function check_quantity_max_stock()
        {
            $('input.input-number[type="number"]').each(function() {
                
                var max_stock = parseInt($(this).parents('.cart_item').find('.item_stock').text());

                if($(this).val() == max_stock)
                {
                    $(this).parents('.cart_item').find('.btn-plus').prop('disabled', true);
                }
                else
                {
                    $(this).parents('.cart_item').find('.btn-plus').prop('disabled', false);
                }
            });
        }

        $(document).ready(function(){
            
            check_quantity_max_stock();
            setup_ajax();
            check_quantity();
            updateQty();
        });
    </script>
@endsection