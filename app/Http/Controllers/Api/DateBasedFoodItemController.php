<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDateBasedFoodItemRequest;
use App\Http\Requests\UpdateDateBasedFoodItemRequest;
use App\Models\DateBasedProducts;

class DateBasedFoodItemController extends Controller
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
     * @param  \App\Http\Requests\StoreDateBasedFoodItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDateBasedFoodItemRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DateBasedProducts  $dateBasedFoodItem
     * @return \Illuminate\Http\Response
     */
    public function show(DateBasedProducts $dateBasedFoodItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DateBasedProducts  $dateBasedFoodItem
     * @return \Illuminate\Http\Response
     */
    public function edit(DateBasedProducts $dateBasedFoodItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDateBasedFoodItemRequest  $request
     * @param  \App\Models\DateBasedProducts  $dateBasedFoodItem
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDateBasedFoodItemRequest $request, DateBasedProducts $dateBasedFoodItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DateBasedProducts  $dateBasedFoodItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(DateBasedProducts $dateBasedFoodItem)
    {
        //
    }
}
