<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Product;

class ProductCategoriesController extends Controller
{
    //
    public function store(Request $request)
    {
        $this->validate($request,[
            'product_category' => 'required'
         ]);

         
 
         // Get the value stored in the form and put it into the database
         $product_category = new ProductCategory();
         $product_category->product_category = $request->input('product_category');
         $product_category->save();
 
         return redirect('admin/inventory')->with('success','Product Category Added Successfully')
                                            ->with('current_tab','products_category');
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'edit_product_category_name' => 'required',
            'edit_category_id' => 'required',
        ]);
        $category_id = $request->input('edit_category_id');
        $category = ProductCategory::find($category_id);
        
        //Update the Category of the Products Listed in the Current Category
        $current_category = $category->product_category;
        $new_category = $request->input('edit_product_category_name');

        $update_products_category = Product::where('product_category', '=', $current_category)->get();

        foreach($update_products_category as $update_products)
        {
            $update_category_products =  Product::find($update_products->id);
            $update_category_products->product_category = $new_category;
            $update_category_products->save();
        }

        // Get the value stored in the form and put it into the database
        $category->product_category = $request->input('edit_product_category_name');
        $category->save();

        return redirect('/admin/inventory')->with('success','Product Category Updated Successfully')
                                            ->with('current_tab','products_category');
    }

    public function destroy(Request $request)
    {
        $this->validate($request,[
            'delete_product_category_id' => 'required',
            'delete_product_category_name' => 'required'
        ]);
        $category_id = $request->input('delete_product_category_id');
        $category = ProductCategory::find($category_id);
        $category->delete();
        

        return redirect('/admin/inventory')->with('success','Product Category Deleted Successfully')
                                            ->with('current_tab','products_category');
    }
}
