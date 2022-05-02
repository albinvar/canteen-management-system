<?php

namespace App\Http\Controllers;

use App\Models\OrderGroup;
use App\Http\Requests\StoreOrderGroupRequest;
use App\Http\Requests\UpdateOrderGroupRequest;

class OrderGroupController extends Controller
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
     * @param  \App\Http\Requests\StoreOrderGroupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderGroupRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderGroup  $orderGroup
     * @return \Illuminate\Http\Response
     */
    public function show(OrderGroup $orderGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderGroup  $orderGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderGroup $orderGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderGroupRequest  $request
     * @param  \App\Models\OrderGroup  $orderGroup
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderGroupRequest $request, OrderGroup $orderGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderGroup  $orderGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderGroup $orderGroup)
    {
        //
    }
}
