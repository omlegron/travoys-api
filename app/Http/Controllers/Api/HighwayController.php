<?php

namespace App\Http\Controllers\Api;

use App\Highway;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HighwayCollection;
use App\Http\Resources\HighwayItem;

class HighwayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new HighwayCollection(Highway::get());
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Highway  $highway
     * @return \Illuminate\Http\Response
     */
    public function show(Highway $highway)
    {
        return new HighwayItem($highway);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Highway  $highway
     * @return \Illuminate\Http\Response
     */
    public function edit(Highway $highway)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Highway  $highway
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Highway $highway)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Highway  $highway
     * @return \Illuminate\Http\Response
     */
    public function destroy(Highway $highway)
    {
        //
    }
}
