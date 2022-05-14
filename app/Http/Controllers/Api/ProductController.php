<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFoodItemRequest;
use App\Http\Requests\UpdateFoodItemRequest;
use App\Models\Product;

class FoodItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFoodItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFoodItemRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $foodItem
     * @return \Illuminate\Http\Response
     */
    public function show(Product $foodItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $foodItem
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $foodItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFoodItemRequest  $request
     * @param  \App\Models\Product  $foodItem
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFoodItemRequest $request, Product $foodItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $foodItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $foodItem)
    {
        //
    }
}
