@extends('layouts.app')

@section('content')

    <div class="container">

        <h1> Post Product </h1>
        {!! Form::open(['route' => 'products.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

            <div class="form-group">
                {{Form::label('product_name', 'Product Name')}}
                {{Form::text('product_name', '', ['class' => 'form-control', 'placeholder' => 'Product Name']) }}
            </div>

            <div class="form-group">
                {{Form::label('product_desc', 'Product Description')}}
                {{Form::textarea('product_desc', '', ['class' => 'form-control', 'placeholder' => 'Product Description']) }}
            </div>

            <div class="form-group">
                {{Form::label('product_price', 'Product Price')}}
                {{Form::number('product_price', '', ['class' => 'form-control', 'placeholder' => 'Product Price']) }}
            </div>

            <div class="form-group">
                {{Form::file('product_img')}}
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-6">
                    {{Form::submit('Submit', ['class' => 'btn btn-primary mr-2']) }}
                    <a href="/products" class="btn btn-primary">Go Back</a>
                </div>
            </div>
        {!! Form::close() !!}

    </div>

@endsection
