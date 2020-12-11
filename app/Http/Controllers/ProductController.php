<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //TODO Add filter by vendor id by auth
        $products = Product::selectRaw("products.*, product_types.name AS type_name, product_types.id AS type_id")
            ->join("product_types", "product_types.id", "products.type_id")
            ->paginate(9);
        return view('product', compact('products'));
    }

    public function addForm()
    {
        $productTypes = ProductType::all();
        return view('product-add', compact('productTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:5',
            'price' => 'required|numeric|min:1000',
            'stock' => 'required|min:1',
            'desc' => 'required|min:10',
            'type' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg'
        ];
        $request->validate($rules);
        $file = $request->file('image');
        $now = Carbon::now();
        $filename = $request->name . "_" . $now->getTimestamp() . "." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/uploads/image/product', $filename);
        $filename = '/uploads/image/product/' . $filename;

        //TODO: get vendor id from auth
        Product::insert([
            "name" => $request->name,
            "price" => $request->price,
            "rating" => 0,
            "stock" => $request->stock,
            "description" => $request->desc,
            "image" => $filename,
            "type_id" => $request->type,
            "vendor_id" => 1
        ]);
        return redirect()->intended('/products')->with("message", "Success Add Products!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $product = Product::where('id', $id)->first();
        $path = "/uploads/image/product/";
        if (substr($product->image, 0, strlen($path)) == $path) {
            unlink(public_path() . $product->image);
        }
        $product->delete();
        return redirect()->intended('/products')->with("message", "Success Deleted Products!");
    }
}
