@extends('layouts.adminApp')

@section('scripts')

    {{-- Data Tables Sort --}}
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    
@endsection

@section('styles')
    <style>

        .products_table{
            overflow-x: scroll;
        }

        .products_table thead tr th{
            text-align: center;
        }

        .products_table tbody tr td{
            text-align: center;
        }

        .categories_table{
            overflow-x: scroll;
        }

        .categories_table thead tr th{
            text-align: center;
        }

        .categories_table tbody tr td{
            text-align: center;
        }

        .dataTables_length, .dataTables_filter{
            padding-top: 10px;
            padding-left: 5px;
            padding-right: 5px;
        }
        
        table.dataTable thead th {
            border-bottom: none;
        }

        .nav-pills .nav-link {
            color: #4b922d;
        }

        .nav-pills .nav-link.active{
            background-color: #4b922d;
        }

    </style>
    
@endsection

@section('content')
    {{-- Breadcrumbs --}}
    <div class="row breadcrumbs_row">
        <div class="col-md-6 col-12 align-self-center breadcrumb_col">
            <h3 class="text-themecolor mb-0">Item Inventory</h3>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                <a href="/admin/dashboard">Administrator</a>
                </li>
                <li class="breadcrumb-item active">Item Inventory</li>
            </ol>
        </div>
        
        {{-- Add Product and Category --}}
        <div class="col-md-6 col-12 text-right align-self-center mt-2">
            <button class="btn page-btn create-btn my-1 body-text" type="button" data-toggle="modal" data-target="#add-product-modal">
                + Add Product
            </button>
            <button class="btn page-btn create-btn my-1 ml-2 body-text" type="button" data-toggle="modal" data-target="#add-product-category-modal">
                + Add Product Category
            </button>
            <button class="btn page-btn create-btn my-1 ml-2 body-text" type="button" data-toggle="modal" data-target="#add-from-csv-modal">
                <i class="fas fa-file-csv"></i>
            </button>
        </div>
    </div>

    <div class="row">
        {{-- No. of Items--}}
        <div class="col-12 col-md-6 d-flex align-items-stretch">
            <div class="col-12 mb-3 px-0">
                <div class="card bg-white text-dark h-100 admin_cards">
                    <div class="card-body my-0 pb-1">
                        <div class="row">
                            <div class="col my-auto pr-0">
                                <span class="value card-number-text text-right">
                                    @if (!empty($items_listed)){{$items_listed}}
                                    @else 0
                                    @endif
                                </span>
                            </div>
                            <div class="col my-auto">
                                <i class="fas fa-pallet fa-3x icon text-left"></i>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-12">
                                <span class="label body-text"> Listed Item(s) Online </span> 
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex">
                        <a href="/admin/inventory" class=" body-text-thin">
                            View All Item(s)
                            <span class="ms-auto">
                                <i class="bi bi-chevron-right"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- No. of Low on Stock Items--}}
        <div class="col-12 col-md-6 d-flex align-items-stretch">
            <div class="col-12 mb-3 px-0">
                <div class="card bg-white text-dark h-100 admin_cards">
                    <div class="card-body my-0 pb-1">
                        <div class="row ">
                            <div class="col my-auto pr-0">
                            <span class="value card-number-text text-right"> 
                                @if (!empty($low_on_stock)){{$low_on_stock}}
                                @else 0
                                @endif
                            </span>
                            </div>
                            <div class="col my-auto">
                                <i class="fas fa-pallet fa-3x icon"></i>
                            </div>
                        </div>
                        <div class="row text-center ">
                            <div class="col">
                            <span class="label body-text"> Low on Stock Item(s) </span> 
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex">
                        <a href="/admin/inventory/lowOnStock" class=" body-text-thin">
                            View Low on Stock Item(s)
                            <span class="ms-auto">
                                <i class="bi bi-chevron-right"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
                    
    {{-- Markup for Products Table --}}
    <div class="row">
        <div class="col">
            
            <ul class="nav nav-pills" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link {{ Session::get('current_tab') != "products_category" ? 'active' : '' }}" id="products-tab" data-toggle="tab" href="#products" role="tab" aria-controls="products" aria-selected="true"><i class="fas fa-box"></i> <span class="body-text">Products </span>   </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ Session::get('current_tab') == "products_category" ? 'active' : '' }}" id="products-category-tab" data-toggle="tab" href="#products-category" role="tab" aria-controls="products-category" aria-selected="false"><i class="fas fa-filter"></i><span class="body-text"> Product Category </span>   </a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">

                <div class="tab-pane fade {{ Session::get('current_tab') != "products_category" ? 'active show' : '' }}" id="products" role="tabpanel" aria-labelledby="products-tab">
                    
                    {{-- Markup for Products Table --}}
                    <div class="row pt-3">
                        <div class="col">
                            <div class="card ">
                                <div class="card-body body-text">

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <span class="card-heading">
                                                @if (Route::is('admin.inventory')) All Products
                                                @elseif (Route::is('products.showLowOnStock')) Low on Stock Items
                                                @endif
                                            </span>
                                        </div>
                                        <div class="col-md-6">
                                        </div>
                                    </div>

                                    <div class="table-responsive" id="products_table">
                                        <table id="products_table_sort" class="table table-striped products_table mt-2 display">
                                            <thead>
                                                <tr>
                                                    <th>Product ID</th>
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>Category</th>
                                                    <th>Price</th>
                                                    <th>Stock</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($products as $product)
                                                    <tr>
                                                        <td>{{$product->id}}</td>
                                                        <td><img src="/storage/product_image/{{$product->product_image}}" alt="" width="60"></td>
                                                        <td>{{$product->product_name}}</td>
                                                        <td>{{$product->product_category}}</td>
                                                        <td>{{number_format($product->product_price, 2)}}</td>
                                                        <td>{{$product->product_stock}}</td>
                                                        <td>{{$product->created_at	}}</td>
                                                        <td>
                                                            <a class="" href="#edit-product-modal" data-toggle="modal" data-product_id="{{$product->id}}" >
                                                                <button type="button" class="btn page-btn">
                                                                    <span> <i class="fas fa-edit"></i></span>
                                                                </button>
                                                            </a> 
                                                        </td>
                                                        <td>
                                                            <a class="" href="#delete-product-modal" data-toggle="modal" data-product_id="{{$product->id}}" >
                                                                <button type="button" class="btn page-btn">
                                                                    <span> <i class="fas fa-trash-alt"></i></span>
                                                                </button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    
                
                                </div>
                              </div>
                        </div>
                    </div>

                </div>

                <div class="tab-pane fade {{ Session::get('current_tab') == "products_category" ? 'active show' : '' }} " id="products-category" role="tabpanel" aria-labelledby="products-category-tab">
                    
                    {{-- Markup for Product Categories Table --}}
                    <div class="row pt-3">
                        <div class="col">
                            <div class="card ">
                                
                                <div class="card-body body-text">
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <span class="card-heading">All Categories</span> 
                                        </div>
                                        <div class="col-md-6">
                                            
                                        </div>
                                    </div>

                                    <div class="table-responsive" id="categories_table">
                                        <table id="categories_table_sort" class="table table-striped categories_table display">
                                            <thead>
                                                <tr>
                                                    <th>Category ID</th>
                                                    <th>Name</th>
                                                    <th>Action</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($product_categories as $product_category)
                                                    <tr>
                                                        <td>{{$product_category->id}}</td>
                                                        <td>{{$product_category->product_category}}</td>
                                                        <td>
                                                            <a class="" href="#edit-product-category-modal" data-toggle="modal" data-category_id="{{$product_category->id}}" >
                                                                <button type="button" class="btn page-btn">
                                                                    <span> <i class="fas fa-edit"></i></span>
                                                                </button>
                                                            </a> 
                                                        </td>
                                                        <td>
                                                            <a class="" href="#delete-product-category-modal" data-toggle="modal" data-category_id="{{$product_category->id}}" >
                                                                <button type="button" class="btn page-btn">
                                                                    <span> <i class="fas fa-trash-alt"></i></span>
                                                                </button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    
                
                                </div>
                                <div class="card-footer text-muted">
                                    <div class="row justify-content-end">
                                        <div class="col">
                                            {{-- {{ $product_categories->links('pagination::bootstrap-4') }} --}}
                                        </div>
                                        <div class="col-md-6">
                                            
                                        </div>
                                    </div>
                                    
                                </div>
                              </div>
                        </div>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>

    {{-- Modals for Product --}}

    {{-- Markup for Add Product Modal --}}
    <div class="modal fade" id="add-product-modal" tabindex="-1" role="dialog" aria-labelledby="add-product-modal" aria-hidden="true">
                    
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title add-product-heading" id="add-product-heading">Add New Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    {!! Form::open(['route' => 'products.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    @csrf

                        <div class="row"  id="product_name_check" >     
                        </div>

                        <div class="form-row justify-content-center">
                            <div class="col-md-6 form-group">
                                {{Form::label('product_name', 'Product Name', ['class' => 'body-text-thick'])}}
                                {{Form::text('product_name', '', ['class' => 'form-control body-text', 'placeholder' => 'Product Name', 'required' => 'required', 'id' => 'product_name' ]) }}
                            </div>
                            <div class="col-md-6 form-group">
                                {{Form::label('product_category', 'Product Category', ['class' => 'body-text-thick'])}}
                                
                                {{Form::select('product_category', $product_categories->pluck('product_category', 'product_category'), null, array('class' => 'form-control body-text', 'required' => 'required', 'id' => 'product_category' ))}}
                                
                            </div>
                        </div>

                        <div class="form-row justify-content-center">
                            <div class="col-md-12 form-group">
                                {{Form::label('product_description', 'Product Description', ['class' => 'body-text-thick'])}}
                                {{Form::textarea('product_description', '', ['class' => 'form-control body-text', 'placeholder' => 'Product Description', 'required' => 'required', 'id' => 'product_description' ]) }}
                            </div>
                        </div>

                        <div class="form-row justify-content-center">
                            <div class="col-md-6 form-group">
                                {{Form::label('product_price', 'Product Price', ['class' => 'body-text-thick'])}}
                                {{Form::number('product_price', '', ['class' => 'form-control body-text', 'step' => 'any', 'placeholder' => 'Product Price', 'required' => 'required', 'id' => 'product_price' ]) }}
                            </div>
                            <div class="col-md-6 form-group">
                                {{Form::label('product_stock', 'Product Quantity in Stock ', ['class' => 'body-text-thick'])}}
                                {{Form::number('product_stock', '', ['class' => 'form-control body-text', 'placeholder' => 'Product Quantity in Stock', 'required' => 'required', 'id' => 'product_stock' ]) }}
                            </div>
                        </div>

                        <div class="form-row justify-content-center">
                            <div class="col-md-12 form-group">
                                {{Form::label('product_image', 'Product Image', ['class' => 'body-text-thick'])}}
                                {{Form::file('product_image')}}
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-xs-12 col-md-12 text-center">
                                {{Form::button('Add', array(
                                    'type' => 'submit',
                                    'class'=> 'btn page-btn body-text',
                                    'id' => 'add_product_btn',
                                    )) 
                                }}
                                <button type="button" class="btn page-btn body-text" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                        
                    {!! Form::close() !!}

                </div>

            </div>
        </div>
    </div>

    {{-- Markup for Add from CSV Modal --}}
    <div class="modal fade" id="add-from-csv-modal" tabindex="-1" role="dialog" aria-labelledby="add-from-csv-modal" aria-hidden="true">
                    
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title add-from-csv-heading" id="add-from-csv-heading">Add Products From CSV</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    {!! Form::open(['route' => 'products.uploadFromCsv', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    @csrf

                        <div class="form-row justify-content-center">
                            <div class="col-md-12 form-group">
                                {{Form::label('products_file', 'CSV / XLSX Products List', ['class' => 'body-text-thick'])}}
                                {{Form::file('products_file')}}
                            </div>
                            <div class="col-md-12 form-group">
                                {{Form::label('product_categories_file', 'CSV / XLSX Product Category List', ['class' => 'body-text-thick'])}}
                                {{Form::file('product_categories_file')}}
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-xs-12 col-md-12 text-center">
                                {{Form::button('Add', array(
                                    'type' => 'submit',
                                    'class'=> 'btn page-btn body-text',
                                    'id' => 'add_product_from_csv_btn',
                                    )) 
                                }}
                                <button type="button" class="btn page-btn body-text" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                        
                    {!! Form::close() !!}

                </div>

            </div>
        </div>
    </div>

    {{-- Markup for Edit Product Modal --}}
    <div class="modal fade" id="edit-product-modal" tabindex="-1" role="dialog" aria-labelledby="edit-product-modal" aria-hidden="true">
                    
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title edit-product-heading" id="edit-product-heading">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    {!! Form::open(['route' => 'products.updateProduct', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    @csrf
                        <div class="row"  id="edit_product_name_check" >     
                        </div>
                    
                        <div class="form-row justify-content-center">
                            <div class="col-md-6 col-xs-6">
                                <div class="form-row">
                                    <div  class="col-md-12 form-group">
                                        {{Form::label('previous_product_image', 'Product Image', ['class' => 'body-text-thick'])}}
                                    </div>
                                </div>
                                <div class="form-row pt-0 mt-0">
                                    <div class="col-md-12 text-center">
                                            @if (!empty($product))
                                                <figure><img style="height: 160px; width: 160px;" src="" alt="" class="productimg img-responsive" id="previous_product_image"></figure> 
                                            @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-6">
                                <div class="form-row">
                                    <div class="col-md-3 form-group">
                                        {{Form::label('edit_product_id', 'Product ID', ['class' => 'body-text-thick'])}}
                                        {{Form::text('edit_product_id', '', ['class' => 'form-control body-text', 'placeholder' => 'Product ID', 'required' => 'required', 'readonly'=>'readonly' ]) }}
                                    </div>
                                    <div class="col-md-9 form-group">
                                        {{Form::label('edit_product_name', 'Product Name', ['class' => 'body-text-thick'])}}
                                        {{Form::text('edit_product_name', '', ['class' => 'form-control body-text', 'placeholder' => 'Product Name', 'required' => 'required' ]) }}
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 form-group">
                                        {{Form::label('edit_product_category', 'Product Category', ['class' => 'body-text-thick'])}}
                                        @if (!empty($product_category))
                                            {{Form::select('edit_product_category', $product_category->pluck('product_category', 'product_category') , null, array('class' => 'form-control body-text', 'required' => 'required' ));}}
                                        @else
                                            {{Form::select('edit_product_category', array('' => '') , null, array('class' => 'form-control body-text', 'required' => 'required' ));}}
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="form-row justify-content-center">
                                    <div class="col-md-6 form-group">
                                        {{Form::label('edit_product_price', 'Product Price', ['class' => 'body-text-thick'])}}
                                        {{Form::number('edit_product_price', '', ['class' => 'form-control body-text', 'step' => 'any', 'placeholder' => 'Product Price', 'required' => 'required' ]) }}
                                    </div>
                                    <div class="col-md-6 form-group">
                                        {{Form::label('edit_product_stock', 'Product Quantity in Stock ', ['class' => 'body-text-thick'])}}
                                        {{Form::number('edit_product_stock', '', ['class' => 'form-control body-text', 'placeholder' => 'Product Quantity in Stock', 'required' => 'required' ]) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row justify-content-center">
                            <div class="col-md-12 form-group">
                                {{Form::label('edit_product_description', 'Product Description', ['class' => 'body-text-thick'])}}
                                {{Form::textarea('edit_product_description', '', ['class' => 'form-control body-text', 'placeholder' => 'Product Description', 'required' => 'required' ]) }}
                            </div>
                        </div>

                        <div class="form-row justify-content-center">
                            <div class="col-md-12 form-group">
                                {{Form::label('edit_product_image', 'Product Image', ['class' => 'body-text-thick'])}}
                                {{Form::file('edit_product_image')}}
                            </div>
                        </div>

                        {{Form::hidden('_method', 'PUT')}}

                        <div class="form-row">
                            <div class="col-xs-12 col-md-12 text-center">
                                {{Form::button('Edit', array(
                                    'type' => 'submit',
                                    'class'=> 'btn page-btn body-text',
                                    'id' => 'edit_product_btn',
                                    )) 
                                }}
                                <button type="button" class="btn page-btn body-text" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                        

                    {!! Form::close() !!}


                </div>

                
                    
            </div>
        </div>
    </div>

    {{-- Markup for Delete Product Modal --}}
    <div class="modal fade" id="delete-product-modal" tabindex="-1" role="dialog" aria-labelledby="delete-product-modal" aria-hidden="true">
            
        <div class="modal-dialog modal-md" role="document">

            <div class="modal-content">

                <div class="modal-header pb-2 mb-3">
                    <h5 class="modal-title delete-product-heading" id="delete-product-heading">Remove Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['route' => 'products.deleteProduct', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    <div class="modal-body">
                        
                        @csrf
                        <div class="row">
                            <div class="col-md-4 text-center">
                                    @if (!empty($product))
                                        <figure><img style="height: 160px; width: 160px;" src="" alt="" class="productimg img-responsive" id="delete_product_image"></figure> 
                                    @endif
                            </div>
                            <div class="col-md-8">
                                <div class="form-row justify-content-center">
                                    <div class="col-md-12 form-group">
                                        {{Form::label('delete_product_id', 'Product ID', ['class' => 'body-text-thick'])}}
                                        {{Form::text('delete_product_id', '', ['class' => 'form-control body-text', 'placeholder' => 'ID', 'required' => 'required', 'readonly'=>'readonly' ]) }}
                                    </div>
                                </div>
                                <div class="form-row justify-content-center">
                                    <div class="col-md-12 form-group">
                                        {{Form::label('delete_product_name', 'Product Name', ['class' => 'body-text-thick'])}}
                                        {{Form::text('delete_product_name', '', ['class' => 'form-control body-text', 'placeholder' => 'Product Name', 'required' => 'required', 'readonly'=>'readonly'  ]) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row justify-content-center">
                            <div class="col-md-12 form-group">
                                <div class="col-md-12 justify-content-center"> 
                                    <p class="delete-product-prompt text-center mb-0 body-text">Are you sure you want to remove this product?</p>
                                </div>    
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <div class="form-row mx-auto">
                            <div class="col-xs-12 col-md-12 ">
                                {{Form::hidden('_method', 'DELETE')}}
                                {{Form::button('Delete', array('type' => 'submit','class'=> 'btn page-btn body-text',)) 
                                }}
                                <button type="button body-text" class="btn page-btn" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
                
                    
            </div>
        </div>
    </div>

    {{-- Modals for Categories --}}

    {{-- Markup for Add Product Category Modal --}}
    <div class="modal fade" id="add-product-category-modal" tabindex="-1" role="dialog" aria-labelledby="add-product-category-modal" aria-hidden="true">
                    
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title add-product-category-heading" id="add-product-category-heading">Add Product Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    {!! Form::open(['route' => 'productCategories.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    @csrf

                        <div class="row"  id="product_category_check" >     
                        </div>

                        <div class="form-row justify-content-center">
                            <div class="col-md-12 form-group">
                                {{Form::label('product_category', 'Product Category', ['class' => 'body-text-thick'])}}
                                {{Form::text('product_category', '', ['class' => 'form-control body-text', 'placeholder' => 'Product Category', 'required' => 'required', 'id' => 'product_category_field' ]) }}
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-xs-12 col-md-12 text-center">
                                {{Form::button('Add', array(
                                    'type' => 'submit',
                                    'class'=> 'btn page-btn body-text',
                                    'id' => 'add_category_btn',
                                    )) 
                                }}
                                <button type="button" class="btn page-btn body-text" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                        

                    {!! Form::close() !!}
                </div>

            </div>
        </div>
    </div>

    {{-- Markup for Edit Product Category Modal --}}
    <div class="modal fade" id="edit-product-category-modal" tabindex="-1" role="dialog" aria-labelledby="edit-product-category-modal" aria-hidden="true">
                
        <div class="modal-dialog modal-md" role="document">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title edit-product-category-heading" id="edit-product-category-heading">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    {!! Form::open(['route' => 'productCategories.update', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    @csrf
                        <div class="row"  id="edit_product_category_check" >     
                        </div>
                    
                        <div class="form-row justify-content-center">
                            <div class="col-md-12 form-group">
                                {{Form::label('edit_category_id', 'Product Category ID', ['class' => 'body-text-thick'])}}
                                {{Form::text('edit_category_id', '', ['class' => 'form-control body-text', 'placeholder' => 'Category ID', 'required' => 'required', 'readonly'=>'readonly' ]) }}
                            </div>
                        </div>

                        <div class="form-row justify-content-center">
                            <div class="col-md-12 form-group">
                                {{Form::label('edit_product_category_name', 'Product Category Name', ['class' => 'body-text-thick'])}}
                                {{Form::text('edit_product_category_name', '', ['class' => 'form-control body-text', 'placeholder' => 'Product Category', 'required' => 'required' ]) }}
                            </div>
                        </div>
                        {{Form::hidden('_method', 'PUT')}}
                        <div class="form-row">
                            <div class="col-xs-12 col-md-12 text-center">
                                {{Form::button('Edit', array(
                                    'type' => 'submit',
                                    'class'=> 'btn page-btn body-text',
                                    'id' => 'edit_category_btn',
                                    )) 
                                }}
                                    <button type="button" class="btn page-btn body-text" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                        

                    {!! Form::close() !!}


                </div>

                
                    
            </div>
        </div>
    </div>

    {{-- Markup for Delete Product Category Modal --}}
    <div class="modal fade" id="delete-product-category-modal" tabindex="-1" role="dialog" aria-labelledby="delete-product-category-modal" aria-hidden="true">
                
        <div class="modal-dialog modal-md" role="document">

            <div class="modal-content">

                <div class="modal-header pb-2 mb-3">
                    <h5 class="modal-title delete-product-category-heading" id="delete-product-category-heading">Remove Product Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['route' => 'productCategories.delete', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    <div class="modal-body">
                        
                        @csrf
                        
                        <div class="form-row justify-content-center">
                            <div class="col-md-12 form-group">
                                {{Form::label('delete_product_category_id', 'Product Category ID', ['class' => 'body-text-thick'])}}
                                {{Form::text('delete_product_category_id', '', ['class' => 'form-control body-text', 'placeholder' => 'ID', 'required' => 'required', 'readonly'=>'readonly' ]) }}
                            </div>
                        </div>

                        <div class="form-row justify-content-center">
                            <div class="col-md-12 form-group">
                                {{Form::label('delete_product_category_name', 'Product Category Name', ['class' => 'body-text-thick'])}}
                                {{Form::text('delete_product_category_name', '', ['class' => 'form-control body-text', 'placeholder' => 'Product Name', 'required' => 'required', 'readonly'=>'readonly'  ]) }}
                            </div>
                        </div>

                        <div class="form-row justify-content-center">
                            <div class="col-md-12 form-group">
                                <div class="col-md-12 justify-content-center text-center"> 
                                    <p class="delete-product-category-prompt body-text">Are you sure you want to remove this product category?</p>
                                </div>    
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <div class="form-row mx-auto">
                            <div class="col-xs-12 col-md-12 ">
                                {{Form::hidden('_method', 'DELETE')}}
                                {{Form::button('Delete', array('type' => 'submit','class'=> 'btn page-btn body-text',)) 
                                }}
                                <button type="button" class="btn page-btn body-text" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
                
                    
            </div>
        </div>
    </div>


@endsection

@section('post-scripts')

    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js" defer></script>

    <script>

        function setup_ajax()
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }

        function clear_modal()
        {

            $('#add-product-modal').on('hidden.bs.modal', function (e) {

                $("#product_name_check").html( ``);
                document.getElementById("add_product_btn").disabled = false;

                $('#product_name').val('');
                $('#product_category').val('');
                $('#product_description').val('');
                $('#product_price').val('');
                $('#product_stock').val('');
                $(this)
                .find("input[type=checkbox], input[type=radio]")
                .prop("checked", "")
                .end();
            });

            $('#add-product-category-modal').on('hidden.bs.modal', function (e) {

                $("#product_category_check").html( ``);
                document.getElementById("add_category_btn").disabled = false;

                $('#product_category_field').val('');
                $(this)
                .find("input[type=checkbox], input[type=radio]")
                .prop("checked", "")
                .end();
            });

            $('#edit-product-modal').on('hidden.bs.modal', function (e) {
                        
                $("#edit_product_name_check").html( ``);
                document.getElementById("edit_product_btn").disabled = false;
                $('#previous_product_image').attr('src', '');

                $('#edit_product_id').val('');
                $('#edit_product_name').val('');
                $('#edit_product_category').val('');
                $('#edit_product_description').val('');
                $('#edit_product_stock').val('');
                $('#edit_product_price').val('');
            });

            $('#edit-product-category-modal').on('hidden.bs.modal', function (e) {

                $("#edit_product_category_check").html( ``);
                document.getElementById("edit_product_btn").disabled = false;
            });

            $('#delete-product-modal').on('hidden.bs.modal', function (e) {

                $('#delete_product_name').val('');
                $('#delete_product_id').val('');
                $('#delete_product_image').attr('src', '');
            });
        }

        function load_product_to_edit_modal()
        {
            $('#edit-product-modal').on('show.bs.modal', function (e) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var product_id = $(e.relatedTarget).data('product_id');
                
                $.ajax({
                    type : 'post',
                    url : '/loadEditInfo',
                    
                    data : {product_id:product_id},
                    dataType: 'json',
                    success : function(data)
                    {
                        $('#previous_product_image').attr('src', '/storage/product_image/'+data.product_image);
                        document.getElementById('edit_product_id').value= product_id;
                        document.getElementById('edit_product_name').value= data.product_name;
                        document.getElementById('edit_product_category').value= data.product_category;
                        document.getElementById('edit_product_description').value= data.product_description;
                        document.getElementById('edit_product_price').value= data.product_price;
                        document.getElementById('edit_product_stock').value= data.product_stock;
                    },
                    error:function(data)
                    {
                        errormsg = JSON.stringify(data);
                        console.log(errormsg);
                    }
                });
            });
        }

        function load_product_to_delete_modal()
        {
            $('#delete-product-modal').on('show.bs.modal', function (e) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var product_id = $(e.relatedTarget).data('product_id');
                
                $.ajax({
                    type : 'post',
                    url : '/loadDeleteInfo',
                    
                    data : {product_id:product_id},
                    dataType: 'json',
                    success : function(data)
                    {
                        $('#delete_product_image').attr('src', '/storage/product_image/'+data.product_image);
                        document.getElementById('delete_product_id').value= product_id;
                        document.getElementById('delete_product_name').value= data.product_name;
                        console.log(data);
                    },
                    error:function(data)
                    {
                        errormsg = JSON.stringify(data);
                        console.log(errormsg);
                    }
                });
            });
        }

        function check_product_name()
        {
            setup_ajax();

            $('#product_name').keyup(function()
            {
                var product_name = $(this).val();


                    if(product_name != '')
                    {
                        $.ajax({
                            url: '/checkProductName',
                            type: 'post',
                            data: {product_name: product_name},
                            success: function(data)
                            {                         
                                if(data == true)
                                {
                                    $("#product_name_check").html 
                                    (
                                        `<div style="text-align:center" class = "alert alert-danger alert-dismissible fade show col-md-6 offset-md-3" role="alert">
                                            Product Already Exists
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>                               
                                        </div>`
                                    );
                                    document.getElementById("add_product_btn").disabled = true;
                                }
                                else
                                {
                                    $("#product_name_check").html( ``);
                                    document.getElementById("add_product_btn").disabled = false;
                                }
                            },
                            error:function(data)
                            {
                                errormsg = JSON.stringify(data);
                                console.log(errormsg);
                            }
                        });

                    }
            });

            
        }

        function check_edit_product_name()
        {
            var selected_product;
            $('#edit-product-modal').on('show.bs.modal', function (e) {

                var product_id = $(e.relatedTarget).data('product_id');
                $.ajax({
                    type : 'post',
                    url : '/loadEditInfo',
                    
                    data : {product_id:product_id},
                    dataType: 'json',
                    success : function(data)
                    {
                        selected_product_name = data.product_name;
                    },
                    error:function(data)
                    {
                        errormsg = JSON.stringify(data);
                        console.log(errormsg);
                    }
                });
            });

            $('#edit_product_name').keyup(function()
            {
                var product_name = $(this).val();

                if(product_name != '')
                {
                    $.ajax({
                        url: '/checkProductName',
                        type: 'post',
                        data: {product_name: product_name},
                        success: function(data)
                        { 
                            if(product_name == selected_product_name && data == true)
                            {
                                $("#edit_product_name_check").html( ``);
                                document.getElementById("edit_product_btn").disabled = false;
                            }                        
                            else if(product_name != selected_product_name && data == true)
                            {
                                $("#edit_product_name_check").html 
                                (
                                    `<div style="text-align:center" class = "alert alert-danger alert-dismissible fade show col-md-6 offset-md-3" role="alert">
                                        Product Already Exists
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>                               
                                    </div>`
                                );
                                document.getElementById("edit_product_btn").disabled = true;
                            }
                            else if(data == false)
                            {
                                $("#edit_product_name_check").html( ``);
                                document.getElementById("edit_product_btn").disabled = false;
                            }
                        },
                        error:function(data)
                        {
                            errormsg = JSON.stringify(data);
                            console.log(errormsg);
                        }
                    });

                }
            });
        }

        function check_category()
        {
            setup_ajax();

            $('#product_category_field').keyup(function()
            {
                var product_category = $(this).val();
                if(product_category != '')
                {
                    $.ajax({
                        url: '/checkProductCategory',
                        type: 'post',
                        data: {product_category: product_category},
                        success: function(data)
                        {                               
                            console.log(data);

                            if(data == true)
                            {
                                $("#product_category_check").html 
                                (
                                    `<div style="text-align:center; font-size: 1em;" class = "alert alert-danger alert-dismissible fade show col-md-6 offset-md-3" role="alert">
                                        Product Category Already Exists
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>                               
                                    </div>`
                                );
                                document.getElementById("add_category_btn").disabled = true;
                            }
                            else
                            {
                                $("#product_category_check").html( ``);
                                document.getElementById("add_category_btn").disabled = false;
                            }

                            
                        },
                        error:function(data)
                        {
                            errormsg = JSON.stringify(data);
                            console.log(errormsg);
                        }
                        
                    });
                }
            });
        }

        function check_edit_category()
        {
            var selected_category;

            $('#edit-product-category-modal').on('show.bs.modal', function (e) {

                var category_id = $(e.relatedTarget).data('category_id');
                $.ajax({
                    type : 'post',
                    url : '/loadCategoryEditInfo',
                    
                    data : {category_id:category_id},
                    dataType: 'json',
                    success : function(data)
                    {
                        selected_category = data.product_category;
                        
                    },
                    error:function(data)
                    {
                        errormsg = JSON.stringify(data);
                        console.log(errormsg);
                    }
                });
            });

            $('#edit_product_category_name').keyup(function()
            {
                var product_category = $(this).val();
                if(product_category != '')
                {
                    $.ajax({
                        url: '/checkProductCategory',
                        type: 'post',
                        data: {product_category: product_category},
                        success: function(data)
                        { 
                            if(product_category == selected_category && data == true)
                            {
                                $("#edit_product_category_check").html( ``);
                                document.getElementById("edit_category_btn").disabled = false;
                            }                        
                            else if(product_name != selected_category && data == true)
                            {
                                $("#edit_product_category_check").html 
                                (
                                    `<div style="text-align:center" class = "alert alert-danger alert-dismissible fade show col-md-6 offset-md-3" role="alert">
                                        Product Category Already Exists
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>                               
                                    </div>`
                                );
                                document.getElementById("edit_category_btn").disabled = true;
                            }
                            else if(data == false)
                            {
                                $("#edit_product_category_check").html( ``);
                                document.getElementById("edit_category_btn").disabled = false;
                            }
                        },
                        error:function(data)
                        {
                            errormsg = JSON.stringify(data);
                            console.log(errormsg);
                        }
                    });

                }
            });
        }

        function load_category_to_edit_modal()
        {
            $('#edit-product-category-modal').on('show.bs.modal', function (e) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var category_id = $(e.relatedTarget).data('category_id');
                
                $.ajax({
                    type : 'post',
                    url : '/loadCategoryEditInfo',
                    
                    data : {category_id:category_id},
                    dataType: 'json',
                    success : function(data)
                    {
                        document.getElementById('edit_category_id').value= category_id;
                        document.getElementById('edit_product_category_name').value= data.product_category;
                    },
                    error:function(data)
                    {
                        errormsg = JSON.stringify(data);
                        console.log(errormsg);
                        // alert(errormsg);
                    }
                });
            });
        }

        function load_category_to_delete_modal()
        {
            $('#delete-product-category-modal').on('show.bs.modal', function (e) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var category_id = $(e.relatedTarget).data('category_id');
                
                $.ajax({
                    type : 'post',
                    url : '/loadCategoryDeleteInfo',
                    
                    data : {category_id:category_id},
                    dataType: 'json',
                    success : function(data)
                    {
                        document.getElementById('delete_product_category_id').value= category_id;
                        document.getElementById('delete_product_category_name').value= data.product_category;
                        // console.log(data);
                    },
                    error:function(data)
                    {
                        errormsg = JSON.stringify(data);
                        console.log(errormsg);
                        // alert(errormsg);
                    }
                });
            });
        }

        //Registersw
        function register_sw()
        {
            navigator.serviceWorker.register('/sw.js');
        }

        //Show Notification
        function showNotification(message)
        {
            // const notification = new Notification ("Koop Hardware Online Store",
            // {
            //     icon: '/storage/logo/icon.png',
            //     body: message
            // });

            // notification.onclick = (e) => 
            // {
            //     window.location.href = "/admin/orders/ordered"
            // }
            
            
            navigator.serviceWorker.getRegistration().then( function( registration )
            {
                
                //Display Notification
                registration.showNotification
                ( 
                    "Koop Hardware Online Store",
                    {
                        icon: '/storage/logo/icon.png',
                        badge:'/storage/logo/icon.png',
                        body:message
                    } 
                );
            } );
            
            
        }

        //Ask for Notification Permissions
        function ask_notif_permission()
        {
            if(Notification.permission !== 'granted')
            {
                Notification.requestPermission();
            }
        }

        //Realtime Refresh and Notification in Admin Dashboard
        function realtime_notif()
		{
			var pusher = new Pusher('03527b096d7dc99cecc1', {
				cluster: 'ap1'
			});

			var channel = pusher.subscribe('admin-channel');
			channel.bind('order-placed-event', function(data) {

                //Desktop Push Notif
                if(Notification.permission == 'granted')
                {   
                    showNotification(data.message['text']);
                }

			});
		}

        $(document).ready(function(){

            register_sw();

            ask_notif_permission();
            realtime_notif();

            $('table.display').DataTable();

            clear_modal();

            check_product_name();
            check_edit_product_name();
            check_category();
            check_edit_category();

            load_product_to_edit_modal();
            load_product_to_delete_modal();
            load_category_to_edit_modal();
            load_category_to_delete_modal();
            // search_products();
        });

    </script>
@endsection