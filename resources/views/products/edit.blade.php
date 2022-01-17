@extends('layouts.app')

@section('content')

    <div class="container">

        <h1> Edit Product </h1>
        {!! Form::open(['route' => ['products.update', $product->id], 'method' => 'POST','enctype' => 'multipart/form-data']) !!}

            <div class="form-group">
                {{Form::label('product_name', 'Product Name')}}
                {{Form::text('product_name', $product->product_name, ['class' => 'form-control', 'placeholder' => 'Product Name']) }}
            </div>

            <div class="form-group">
                {{Form::label('product_desc', 'Product Description')}}
                {{Form::textarea('product_desc', $product->product_description, ['class' => 'form-control', 'placeholder' => 'Product Description']) }}
            </div>

            <div class="form-group">
                {{Form::file('product_img')}}
            </div>

            {{Form::hidden('_method', 'PUT')}}
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    {{Form::submit('Submit', ['class' => 'btn btn-primary mr-2']) }}
                    <a href="/products/{{$product->id}}" class="btn btn-primary">Go Back</a>
                </div>
            </div>
 
        {!! Form::close() !!}

    </div>

@endsection
