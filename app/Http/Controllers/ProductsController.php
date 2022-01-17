<?php

namespace App\Http\Controllers;

use App\Models\Product; //To use the model from product
use App\Models\ProductCategory;
use Symfony\Component\HttpFoundation\Response;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use Intervention\Image\ImageManagerStatic as Image;
use Cart;

use Excel;
use App\Imports\ProductsImport;
use App\Imports\ProductCategoriesImport;


class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //To include the authorization features for login
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
    }

    public function index()
    {
        //Display
        // $posts = Post::all();
        // $posts = DB::select('select * from posts' ); //Get data from db using DB 
        // $current_user = Auth::id(); ///Another method of getting the user id
       
        
        if (Auth::check())
        {   
            $current_user = auth()->user()->id;
            $products = Product::orderBy('product_name','asc')->get(); // sort by name

            $data = array
            (
                'current_user' => $current_user ,
                'products' =>  $products
            );
        }

        else
        {
            $current_user = 'No Current User';
            $products = Product::orderBy('product_name','asc')->get(); // sort by name
            $data = array
            (
                'current_user' => $current_user,
                'products' =>  $products
            );
        }
        
        
        return view('products.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Page containing the forms to fill up
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Save data from the form to db
        $this->validate($request,[
           'product_name' => 'required',
           'product_category' => 'required',
           'product_description' => 'required',
           'product_price' => 'required',
           'product_stock' => 'required',
           'product_image' => 'image|nullable|max:1999'
        ]);

        //Image upload handling
        if($request->hasFile('product_image'))
        {
            //Get filename and extension
            $fileNameWithExt = $request->file('product_image')->getClientOriginalName();
            //Get filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Get extension
            $extension = $request->file('product_image')->getClientOriginalExtension();
            //Set the final file name 
            $fileNameToStore = $fileName .'_'.time().'.'.$extension;

            $image = $request->file('product_image');

            //Resize all image to be uploaded to have the same size
            $image_resize = Image::make($image->getRealPath());              
            $image_resize_hd = Image::make($image->getRealPath());     

            $image_resize->resize(188, 188);
            $image_resize_hd->resize(400, 400);

            $path = 'storage/product_image/'. $fileNameToStore;
            $path_hd = 'storage/product_image_hd/'. $fileNameToStore;

            $image_resize->save($path);
            $image_resize_hd->save($path_hd);
        }
        else
        {
            $fileNameToStore = 'noimg.png';
        }

        // Get the value stored in the form and put it into the database
        $product = new Product;
        $product->product_name = $request->input('product_name');
        $product->product_category = $request->input('product_category');
        $product->product_description = $request->input('product_description');
        $product->product_price = $request->input('product_price');
        $product->product_stock = $request->input('product_stock');
        $product->product_image = $fileNameToStore;
        $product->save();

        return redirect('admin/inventory')->with('success','Product Added Successfully');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Show only one specific info
        $product = Product::find($id);
        $suggestions = Product::where('id', '!=', $product)
                                ->where('product_stock', '>', 0)
                                ->inRandomOrder()->take(4)->get();
        $data = array
        (
            'product' =>  $product,
            'suggestions' =>  $suggestions,
            'title' =>  $product->product_name
            
        );
        return view('pages.productInfo')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Get the current value and put it in the form for editing

        $product = Product::find($id);
        return view('products.edit')->with('product',$product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
         //Save data from the form to db
        $this->validate($request,[
            'edit_product_id' => 'required',
            'edit_product_name' => 'required',
            'edit_product_category' => 'required',
            'edit_product_description' => 'required',
            'edit_product_price' => 'required',
            'edit_product_stock' => 'required',
            'edit_product_image' => 'image|nullable|max:1999'
        ]);
        $product_id = $request->input('edit_product_id');
        $product = Product::find($product_id);

        //Image upload handling
        if($request->hasFile('edit_product_image'))
        {
            //Get filename and extension
            $fileNameWithExt = $request->file('edit_product_image')->getClientOriginalName();
            //Get filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Get extension
            $extension = $request->file('edit_product_image')->getClientOriginalExtension();
            //Set the final file name 
            $fileNameToStore = $fileName .'_'.time().'.'.$extension;
            //upload image

            $image = $request->file('edit_product_image');

            //Resize all image to be uploaded to have the same size
            $image_resize = Image::make($image->getRealPath());              
            $image_resize->resize(188, 188);
            $path = 'storage/product_image/'. $fileNameToStore;
            $image_resize->save($path);
            // $path = $request->file('product_img')->storeAs('public/product_img', $fileNameToStore);
        }

        // Get the value stored in the form and put it into the database
        $product->product_name = $request->input('edit_product_name');
        $product->product_category = $request->input('edit_product_category');
        $product->product_description = $request->input('edit_product_description');
        $product->product_price = $request->input('edit_product_price');
        $product->product_stock = $request->input('edit_product_stock');
        if($request->hasFile('edit_product_image'))
        {
           if($product->product_image !== 'noimg.png')
           {
               $previous_product_image = $product->product_image;
               Storage::delete(['public/product_image/'.$previous_product_image]);
           }
           $product->product_image = $fileNameToStore;
        }
        $product->save();

         return redirect('/admin/inventory')->with('success','Product Updated Successfully');
         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if($product->product_image !== 'noimg.png')
        {
            Storage::delete(['public/product_image/'.$product->product_image]);
        }

        //Delete the specific data from the database with the given ID 
        $product = Product::find($id);

        


        $product->delete();
        

        return redirect('/products')->with('success','Product Deleted Successfully');
    }
    
    //Update function
    public function updateProduct(Request $request)
    {
        //
        $this->validate($request,[
            'edit_product_id' => 'required',
            'edit_product_name' => 'required',
            'edit_product_category' => 'required',
            'edit_product_description' => 'required',
            'edit_product_price' => 'required',
            'edit_product_stock' => 'required',
            'edit_product_image' => 'image|nullable|max:1999'
        ]);
        $product_id = $request->input('edit_product_id');
        $product = Product::find($product_id);

        //Image upload handling
        if($request->hasFile('edit_product_image'))
        {
            //Get filename and extension
            $fileNameWithExt = $request->file('edit_product_image')->getClientOriginalName();
            //Get filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Get extension
            $extension = $request->file('edit_product_image')->getClientOriginalExtension();
            //Set the final file name 
            $fileNameToStore = $fileName .'_'.time().'.'.$extension;
            //upload image

            $image = $request->file('edit_product_image');

            //Resize all image to be uploaded to have the same size
            $image_resize = Image::make($image->getRealPath());      
            $image_resize_hd = Image::make($image->getRealPath());      
            $image_resize->resize(188, 188);
            $image_resize_hd->resize(400, 400);
            $path = 'storage/product_image/'. $fileNameToStore;
            $path_hd = 'storage/product_image_hd/'. $fileNameToStore;
            $image_resize->save($path);
            $image_resize_hd->save($path_hd);
            // $path = $request->file('product_img')->storeAs('public/product_img', $fileNameToStore);
        }

        // Get the value stored in the form and put it into the database
        $product->product_name = $request->input('edit_product_name');
        $product->product_category = $request->input('edit_product_category');
        $product->product_description = $request->input('edit_product_description');
        $product->product_price = $request->input('edit_product_price');
        $product->product_stock = $request->input('edit_product_stock');
        if($request->hasFile('edit_product_image'))
        {
           if($product->product_image !== 'noimg.png')
           {
               $previous_product_image = $product->product_image;
               Storage::delete(['public/product_image/'.$previous_product_image]);
               Storage::delete(['public/product_image_hd/'.$previous_product_image]);
           }
           $product->product_image = $fileNameToStore;
        }
        $product->save();

        return back()->with('success','Product Updated Successfully');
    }
    public function initializeCart()
    {
        if(Auth::check())
        {
            Cart::instance('cart')->store(Auth::user()->email);
        }
    }

    public function restoreCart()
    {
        if(Auth::check())
        {
            Cart::instance('cart')->restore(Auth::user()->email);
        }
    }
    //Delete Function
    public function deleteProduct(Request $request)
    {
        $this->validate($request,[
            'delete_product_id' => 'required',
            'delete_product_name' => 'required'
        ]);
        $product_id = $request->input('delete_product_id');
        $product = Product::find($product_id);

        if($product->product_image !== 'noimg.png')
        {
            Storage::delete(['public/product_image/'.$product->product_image]);
            Storage::delete(['public/product_image_hd/'.$product->product_image]);
        }

        //Get all Registered Email in Cart 
        $cart_emails = DB::table('shoppingcart')->get();
        
        $product_name = $product->product_name;
        foreach($cart_emails as $cart_email)
        {
            Cart::instance('cart')->restore($cart_email->identifier);
            foreach(Cart::instance('cart')->content() as $items)
            {
                $rowId= $items->rowId;
                $cart_product_name = $items->name;

                if($product_name == $cart_product_name )
                {
                    Cart::instance('cart')->remove($rowId);
                }
            }
            Cart::instance('cart')->store($cart_email->identifier);
            $request->session()->forget('cart');
        }

        //Delete the specific data from the database with the given ID 
        // $product = Product::find($id);
        $product->delete();
        
        return redirect('/admin/inventory')->with('success','Product Deleted Successfully');
    }

    //Show Low on Stock Products
    public function showLowOnStock(Request $request)
    {
        $products= Product::where('product_stock', '<', '20')->get();
        $product_categories = ProductCategory::orderBy('product_category','asc')->get(); // sort by name
        $low_on_stock= Product::where('product_stock', '<', '20')->count();
        $items_listed = Product::count();

        $data = array
        (
        'products' =>  $products,
        'product_categories' =>  $product_categories,
        'low_on_stock' =>  $low_on_stock,
        'items_listed' =>  $items_listed,
        'title' =>  'Inventory Management'
        );

        return view('admin.inventory')->with($data);
    }

    //Upload through CSV Excel
    public function uploadFromCsv(Request $request)
    {
        if($request->hasFile('products_file') && $request->hasFile('product_categories_file'))
        {
            try 
            {
                Excel::import(new ProductsImport, $request->file('products_file'));
            } 
            
            catch (\Exception $e)
            {
                return redirect('/admin/inventory')->with('error','Error, File Format Incorrect');
            }

            try 
            {
                Excel::import(new ProductCategoriesImport, $request->file('product_categories_file'));
            } 
            
            catch (\Exception $e)
            {
                return redirect('/admin/inventory')->with('error','Error, File Format Incorrect');
            }
        }
        else if($request->hasFile('products_file') && !($request->hasFile('product_categories_file')))
        {
            try 
            {
                Excel::import(new ProductsImport, $request->file('products_file'));
            } 
            
            catch (\Exception $e)
            {
                return redirect('/admin/inventory')->with('error','Error, File Format Incorrect');
            }
        }
        else if(!($request->hasFile('products_file')) && $request->hasFile('product_categories_file'))
        {
            try 
            {
                Excel::import(new ProductCategoriesImport, $request->file('product_categories_file'));
            } 
            
            catch (\Exception $e)
            {
                return redirect('/admin/inventory')->with('error','Error, File Format Incorrect');
            }
        }

        return redirect('/admin/inventory')->with('success','Data Uploaded Successfully');
       
        


        
    }

}
