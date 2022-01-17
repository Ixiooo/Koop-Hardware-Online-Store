<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use DB;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Display
        // $posts = Post::all();
        $products = Post::orderBy('product_name','asc')->get(); // sort by name
        // $posts = DB::select('select * from posts' ); //Get data from db using DB 
        return view('posts.index')->with('products',$products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Page containing the forms to fill up
        return view('posts.create');
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
           'product_desc' => 'required' 
        ]);

        // Get the value stored in the form and put it into the database
        $product = new Post;
        $product->product_name = $request->input('product_name');
        $product->product_description = $request->input('product_desc');
        $product->save();

        return redirect('/posts')->with('success','Product Uploaded Successfully');
        
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
        $product = Post::find($id);
        return view('posts.show')->with('product',$product);
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

        $product = Post::find($id);
        return view('posts.edit')->with('product',$product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

         //Save data from the form to db
         $this->validate($request,[
            'product_name' => 'required',
            'product_desc' => 'required' 
         ]);
 
         // Get the value stored in the form and put it into the database
         $product = Post::find($id);
         $product->product_name = $request->input('product_name');
         $product->product_description = $request->input('product_desc');
         $product->save();
 
         return redirect('/posts')->with('success','Product Updated Successfully');
         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Delete the specific data from the database with the given ID 
        $product = Post::find($id);
        $product->delete();

        return redirect('/posts')->with('success','Product Deleted Successfully');
    }
}
