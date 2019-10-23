<?php

namespace App\Http\Controllers\Api;

use App\Eatery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EateryCollection;
use App\Http\Resources\EateryItem;

class EateryController extends Controller
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
        return new EateryCollection(Eatery::get());
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
     * @param  \App\Eatery  $eatery
     * @return \Illuminate\Http\Response
     */
    public function show($restArea, Eatery $eatery)
    {
        return new EateryItem($eatery);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Eatery  $eatery
     * @return \Illuminate\Http\Response
     */
    public function edit(Eatery $eatery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Eatery  $eatery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Eatery $eatery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Eatery  $eatery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Eatery $eatery)
    {
        //
    }
}
