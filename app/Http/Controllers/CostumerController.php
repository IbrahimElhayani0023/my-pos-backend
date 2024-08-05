<?php

namespace App\Http\Controllers;

use App\Http\Requests\CostumerRequest;
use App\Http\Resources\CostumerResource;
use App\Models\Costumer;
use Illuminate\Http\Request;

class CostumerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CostumerResource::collection(Costumer::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CostumerRequest $request)
    {
        $validated = $request->validated();

        return Costumer::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Costumer $costumer)
    {
        return new CostumerResource($costumer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CostumerRequest $request, Costumer $costumer)
    {
        $validated = $request->validated();

        $costumer->update($validated);
        
        return response()->json(['message' => 'Costumer updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Costumer $costumer)
    {
        $costumer->delete();

        return response()->json(['message' => 'Costumer deleted successfully'], 200);
    }
}
