<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductResource::collection(Product::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $validated = $request->validated();

        // check if product image is provided
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        // if product image is not provided, set image to null
        } else $validated['image'] = null;
        // create product and return response
        return Product::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $validated = $request->validated();
        // check if product image is provided
        if ($request->hasFile('image')) {
            // add image to storage
            $validated['image'] = $request->file('image')->store('products', 'public');
            // delete previous image
            // $product->image ? \Storage::delete($product->image) : null;
        // if product image is not provided, set image to previous image
        }else $validated['image'] = $product->image;
        
        $product->update($validated);

        return response()->json(['message' => 'Product updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        // delete previous image
        // $product->image ? \Storage::delete($product->image) : null;
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
