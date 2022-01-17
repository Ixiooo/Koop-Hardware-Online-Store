@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-3 justify-content-between">
        <div class="col-3">
            <img style="width: 100%" src="/storage/product_image/{{$product->product_image}}" alt="">
        </div>
        <div class="col-4 my-auto">
            <h1> {{$product->product_name}} </h1>
            <p> {{$product->product_description}} </p>
        </div>
        <div class="col-5 ">
            <div class="row justify-content-end">
                <div class="col-md-4">
                    @if (!Auth::guest())
                        {!! Form::open(['route'=>['products.destroy', $product->id], 'method' => 'POST']) !!}
                        {!! Form::hidden('_method','DELETE') !!}
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type'=>'submit','class'=>'btn btn-primary float-right mr-2' ]) !!}
                        {!! Form::close() !!}
                        <a href="/products/{{$product->id}}/edit" class="btn btn-primary float-right mr-2"> <i class="far fa-edit"></i>  </a>
                    @endif
                </div>
            </div>
           
        </div>
    </div>
    <hr>
    <small> Written on {{$product->created_at}} </small>
    <div class="row">
        <div class="col-md-12">
            <a href="/products" class="btn btn-primary float-right">Go Back</a>
        </div>
    </div>
    
    
</div>
@endsection
