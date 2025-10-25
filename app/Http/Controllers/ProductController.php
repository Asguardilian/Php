<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
     
    public function index()
    {
        $products = Product::get();
        return view('products.index', compact('products'));
    }

    
    public function create()
    {
        return view('products.create_update');
    }
   /**
     * Store a newly created resource in storage.
     * 
    
     */
    public function store(Request $request)
    {
        Product::create($request->all());
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return 'O id do usuário é: ' . $id;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)

    {
        $product = Product::find($id);
        return view('products.create_update', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Product::find($id)->update($request->all());
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::find($id)->delete();
        return redirect()->route('products.index');
    }
}
