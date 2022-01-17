@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-around">
        <div class="col">
            <h1> Product Posts </h1>
        </div>
        <div class="col">
            @auth
                @if ((Auth::user()->user_type === 'admin'))
                    <a href="/products/create" class="btn btn-primary float-right">Add New Product</a>
                @endif
            @endauth
            
        </div>
    </div>

    @if (!Auth::guest())
        <h1> Current User ID: {{$current_user}} </h1>
    @endif
    
                        

    @if (count($products)> 0 )
        @foreach ($products as $product )

            <div class="card">
                <div class="row">
                    <div class="col-md-4 my-auto">
                        <img style="width: 100%" src="/storage/product_image/{{$product->product_image}}" alt="">
                    </div>
                    <div class="col-md-8 my-auto">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <h3> <a href="/products/{{$product->id}}"> {{$product->product_name}} </h3> </a>
                                <small> Written on {{$product->created_at}} </small> 
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
        @endforeach
    @else

    @endif


</div>
@endsection
