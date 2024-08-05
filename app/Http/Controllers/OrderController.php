<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Order::with('costumer')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        // validate request data
        $request->validated();

        // check if product quantity is greater than stock
        foreach ($request['products'] as $product) {
            if ((Product::find($product['product_id'])->stock ?? 0) < $product['quantity']) {
                return response()->json(['message' => 'Product not found or the quantity is greater than stock'], 400);
            }
        }

        $order = Order::create([
            'order_number' => "ORDER-" . uniqid(),
            'costumer_id' => $request->costumer_id,
            'total_price' => $request->total_price,
        ]);
        foreach ($request->products as $product) {
            \App\Models\ProductItem::create([
                'order_id' => $order->id,
                'product_id' => $product['product_id'],
                'product_name' => Product::find($product['product_id'])->name,
                'product_price' => $product['price'],
                'product_quantity' => $product['quantity'],
            ]);

            // decrement product stock
            Product::find($product['product_id'])->decrement('stock', $product['quantity']);
        }
        // return order data
        return response()->json([
            'message' => 'Order created successfully',
        ], 201);
    }
    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $data = $order->with(['costumer', 'items'])->get();
        // return $data;
        return response()->json([
            'message' => 'Order retrieved successfully',
            'data' => $data
        ], 200);
    }
}
