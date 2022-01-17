<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;

class AjaxController extends Controller
{
    //

    //
    public function refreshToken(Request $request)
    {
        session()->regenerate();
        return response()->json([
            "token"=>csrf_token()],
        200);
    }

    //AJAX Calls for Admin Products
    public function loadEditInfo(Request $request)
    {
        $this->validate($request,[
            'product_id' => 'required'
        ]);

        $product_id  = $request->input('product_id');

        $product = Product::find($product_id);
        return response() ->json($product);

    }

    public function loadDeleteInfo(Request $request)
    {
        $product_id  = $request->input('product_id');

        $product = Product::find($product_id);
        return response() ->json($product);
    }

    public function loadSearchResults(Request $request)
    {
        $search  = $request->input('search');
        
        $search_results = Product::where('id', 'like', "%$search%")
                                ->orWhere('product_name', 'like', "%$search%")  
                                ->orWhere('product_description', 'like', "%$search%")
                                ->orWhere('created_at', 'like', "%$search%") 
                                ->orWhere('product_image', 'like', "%$search%") 
                                ->orWhere('product_price', 'like', "%$search%") 
                                ->orWhere('product_category', 'like', "%$search%") 
                                ->orWhere('product_stock', 'like', "%$search%")  
                                ->orderBy('product_name', 'asc')  
                                ->get();

        if( $search_results->count()>0 )
        {
            $html= 
            '
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Date</th>
                            <th>Action</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
            ';

            foreach($search_results as $search_result)
            {
                $html.='
                                <tr>
                                    <td>'.$search_result['id'].'</td>
                                    <td><img src="/storage/product_image/'.$search_result['product_image'].'" alt="" width="60"></td>
                                    <td>'.$search_result['product_name'].'</td>
                                    <td>'.$search_result['product_description'].'</td>
                                    <td>'.$search_result['product_category'].'</td>
                                    <td>'.$search_result['product_price'].'</td>
                                    <td>'.$search_result['product_stock'].'</td>
                                    <td>'.$search_result['created_at'].'</td>
                                    <td>
                                        <a class="" href="#edit-product-modal" data-toggle="modal" data-product_id="'.$search_result['id'].'" >
                                            <button type="button" class="btn btn-primary">
                                                <span> <i class="fas fa-edit"></i></span>
                                            </button>
                                        </a> 
                                    </td>
                                    <td>
                                        <a class="" href="#delete-product-modal" data-toggle="modal" data-product_id="'.$search_result['id'].'" >
                                            <button type="button" class="btn btn-primary">
                                                <span> <i class="fas fa-trash-alt"></i></span>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            
                    
                ';
            }

            $html.='
                        </tbody>
                    </table>
                    ';

            echo $html;
            
            // return response()->json($search_result);
        }
        else
        {
            echo "Sorry, we could not find any results for \"".$search ."\"";
        }

    }

    public function checkProductName(Request $request)
    {
        $product_name  = $request->input('product_name');

        if (Product::where('product_name', '=', $product_name)->exists()) 
        {
            return true;
        }
        else
        {
            return false;
        }

    }

    public function checkProductCategory(Request $request)
    {
        $product_category  = $request->input('product_category');

        if (ProductCategory::where('product_category', '=', $product_category)->exists()) 
        {
            return true;
        }
        else
        {
            return false;
        }

    }
    
    //AJAX Calls for Admin Product Categories
    public function loadCategoryEditInfo(Request $request)
    {
        $category_id  = $request->input('category_id');

        $category = ProductCategory::find($category_id);
        return response() ->json($category);
    }

    public function loadCategoryDeleteInfo(Request $request)
    {
        $category_id  = $request->input('category_id');

        $category = ProductCategory::find($category_id);
        return response() ->json($category);
    }


}
