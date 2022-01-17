<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Route;
use Cart;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    //

    public function initializeCart()
    {
        if(Auth::check())
        {
            Cart::instance('cart')->store(Auth::user()->email);
        }
    }

    // Index Page (All Product) and Sort
    public function sortNameAToZ()
    {
        $title = 'Store';
        $products = Product::where('product_stock', '>', 0)
                            ->orderBy('product_name','asc')
                            ->paginate(12,['*'], 'products'); // sort by name
        $product_categories = ProductCategory::orderBy('product_category','asc')->get(); // sort by name

        $data = array
        (
            'products' =>  $products,
            'product_categories' => $product_categories,
            'title' => $title
        );

        return view('pages.index')->with($data);
    }

    public function sortNameZToA()
    {
        $title = 'Store';
        $products = Product::where('product_stock', '>', 0)
                            ->orderBy('product_name','desc')
                            ->paginate(12,['*'], 'products'); // sort by name desc
        $product_categories = ProductCategory::orderBy('product_category','asc')->get(); // sort by name

        $data = array
        (
            'products' =>  $products,
            'product_categories' => $product_categories,
            'title' => $title
        );

        return view('pages.index')->with($data); 
    }

    public function sortPriceLowToHigh()
    {
        $title = 'Store';
        $products = Product::where('product_stock', '>', 0)
                            ->orderBy('product_price','asc')
                            ->paginate(12,['*'], 'products'); // sort by price
        $product_categories = ProductCategory::orderBy('product_category','asc')->get(); // sort by name

        $data = array
        (
            'products' =>  $products,
            'product_categories' => $product_categories,
            'title' => $title
        );

        return view('pages.index')->with($data); 
    }

    public function sortPriceHighToLow()
    {
        $title = 'Store';
        $products = Product::where('product_stock', '>', 0)
                            ->orderBy('product_price','desc')
                            ->paginate(12,['*'], 'products'); // sort by price desc
        $product_categories = ProductCategory::orderBy('product_category','asc')->get(); // sort by name

        $data = array
        (
            'products' =>  $products,
            'product_categories' => $product_categories,
            'title' => $title
        );

        return view('pages.index')->with($data); 
    }
    
    // Show by Category and Sort
    public function sortByCategoryAll(Request $request, $product_category)
    {
        $title = 'Store';
        $products = Product::where('product_stock', '>', 0)
                            ->where('product_category', '=', $product_category)
                            ->orderBy('product_name','asc')
                            ->paginate(12,['*'], 'products'); // sort by name
        $product_categories = ProductCategory::orderBy('product_category','asc')->get(); // sort by name
        $sortedBy ='productNameAsc';
        $data = array
        (
            'products' =>  $products,
            'product_categories' => $product_categories,
            'current_category' => $product_category,
            'sortedBy' => $sortedBy,
            'title' => $title

        );

        return view('pages.showProductsByCategory')->with($data);
    }

    public function sortByCategorySort(Request $request, $product_category, $sortBy, $order)
    {
        $title = 'Store';
        $product_category = str_replace('%20', ' ', $product_category);

        $sortedBy = '';
        if( $sortBy == 'product_name')
        {
            if($order == 'asc')
            {
                $sortedBy = 'productNameAsc';
            }
            if($order == 'desc')
            {
                $sortedBy = 'productNameDesc';
            }
        }
        else if( $sortBy == 'product_price')
        {
            if($order == 'asc')
            {
                $sortedBy = 'productPriceAsc';
            }
            if($order == 'desc')
            {
                $sortedBy = 'productPriceDesc';
            }
        }

        $products = Product::where('product_stock', '>', 0)
                                ->where('product_category', '=', $product_category)
                                ->orderBy($sortBy, $order)
                                ->paginate(12,['*'], 'products');
        $product_categories = ProductCategory::orderBy('product_category','asc')->get();

        $data = array
        (
            'products' =>  $products,
            'product_categories' => $product_categories,
            'sortedBy' => $sortedBy,
            'current_category' => $product_category,
            'title' => $title
        );

        return view('pages.showProductsByCategory')->with($data);
    }

    //Show Search and Sort

    public function showSearch()
    {
        $title = 'Store';
        $sortedBy ='productNameAsc';
        $search = $_GET['search'];
        if($search == '')
        {
            $search = ' ';
        }
        $products = Product::where('product_stock', '>', 0)
                            ->where('product_name', 'LIKE', '%'.$search.'%') 
                            ->orderBy('product_name','asc')
                            ->paginate(12,['*'], 'products');
        $product_categories = ProductCategory::orderBy('product_category','asc')->get();

        $data = array
        (
            'products' =>  $products,
            'product_categories' => $product_categories,
            'current_search' => $search,
            'sortedBy' => $sortedBy,
            'title' => $title
        );

        return view('pages.search')->with($data);
    }

    public function searchSort(Request $request, $current_search, $sortBy, $order)
    {
        $current_search = str_replace('%20', ' ', $current_search);
        $title = 'Store';

        $sortedBy = '';
        if( $sortBy == 'product_name')
        {
            if($order == 'asc')
            {
                $sortedBy = 'productNameAsc';
            }
            if($order == 'desc')
            {
                $sortedBy = 'productNameDesc';
            }
        }
        else if( $sortBy == 'product_price')
        {
            if($order == 'asc')
            {
                $sortedBy = 'productPriceAsc';
            }
            if($order == 'desc')
            {
                $sortedBy = 'productPriceDesc';
            }
        }

        $products = Product::where('product_stock', '>', 0)
                            ->where('product_name', 'LIKE', '%'.$current_search.'%')
                            ->orderBy($sortBy, $order)
                            ->paginate(12,['*'], 'products');
        $product_categories = ProductCategory::orderBy('product_category','asc')->get();
        $data = array
        (
            'products' =>  $products,
            'product_categories' => $product_categories,
            'current_search' => $current_search,
            'sortedBy' => $sortedBy,
            'title' => $title

        );

        return view('pages.search')->with($data);
    }
}
