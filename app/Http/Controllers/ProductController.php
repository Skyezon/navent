<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use App\ProductType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $selector = $request->query('type_id') != null ? "products.type_id = " .  $request->query('type_id') : "1=1";
        //TODO Add filter by vendor id by auth ???
        $products = Product::selectRaw("products.*, product_types.name AS type_name, product_types.id AS type_id")
            ->join("product_types", "product_types.id", "products.type_id")
            ->whereRaw($selector)
            ->paginate(9);

        $types = ProductType::all();

        $carts = Cart::where('organizer_id', Auth::user()->vendorId())
            ->get();
        foreach ($products as $product) {
            foreach ($carts as $cart) {
                if ($cart->product_id == $product->id) {
                    $product->quantity = $cart->quantity;
                    break;
                }
            }
        }
        return view('product', compact('products', 'types'));
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

        Product::insert([
            "name" => $request->name,
            "price" => $request->price,
            "rating" => 0,
            "stock" => $request->stock,
            "description" => $request->desc,
            "image" => $filename,
            "type_id" => $request->type,
            "vendor_id" => Auth::user()->vendorId()
        ]);
        return redirect()->intended('/products')->with("message", "Success Add Products!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $carts = Cart::where('organizer_id', Auth::user()->organizerId())
            ->get();
        $product = Product::where('id', $id)->first();
        foreach ($carts as $cart) {
            if ($cart->product_id == $product->id) {
                $product->quantity = $cart->quantity;
                break;
            }
        }
        return view('product-detail', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function editForm($id)
    {
        $product = Product::where('id', $id)->first();
        $productTypes = ProductType::all();
        return view('product-add', compact('productTypes', 'product', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|min:5',
            'price' => 'required|numeric|min:1000',
            'stock' => 'required|min:1',
            'desc' => 'required|min:10',
            'type' => 'required',
            'image' => 'nullable|mimes:jpg,png,jpeg'
        ];
        $request->validate($rules);
        $file = $request->file('image');
        $product = Product::where('id', $id)->first();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->description = $request->desc;
        $product->type_id = $request->type;

        if ($file != null) {
            $filename = $request->name . "." . $file->getClientOriginalExtension();
            $path = "/uploads/image/product/";
            if (substr($product->image, 0, strlen($path)) == $path) {
                unlink(public_path() . $product->image);
            }
            $file->move(public_path() . '/uploads/image/product', $filename);
            $product->image = '/uploads/image/product/' . $filename;
        }
        $product->save();

        return redirect()->intended('/products')->with("message", "Success Updated Products!");
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

    public function search(Request $request)
    {
        $query = $request->query('query');
        $movies = Product::where('name', 'LIKE', '%' . $query . '%')->get();
        if (strlen($query) == 0 || count($movies) == 0) {
            return response()->json([
                'message' => 'Not Found'
            ]);
        }
        return response()->json($movies);
    }
}
