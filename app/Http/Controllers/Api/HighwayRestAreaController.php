<?php

namespace App\Http\Controllers\Api;

use App\Highway;
use App\RestArea;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RestAreaCollection;
use App\Http\Resources\RestAreaItem;

class HighwayRestAreaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');

        $this->authorizeResource(RestArea::class, 'rest_area');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Highway  $highway
     * @return \Illuminate\Http\Response
     */
    public function index(Highway $highway)
    {
        $this->authorize('list', RestArea::class);

        return new RestAreaCollection($highway->restArea);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Highway  $highway
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Highway $highway)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Highway  $highway
     * @param  \App\RestArea  $restArea
     * @return \Illuminate\Http\Response
     */
    public function show(Highway $highway, RestArea $restArea)
    {
        return $highway->restArea()->with('places')->findOrFail($restArea);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Highway  $highway
     * @param  \App\RestArea  $restArea
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Highway $highway, RestArea $restArea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Highway  $highway
     * @param  \App\RestArea  $restArea
     * @return \Illuminate\Http\Response
     */
    public function destroy(Highway $highway, RestArea $restArea)
    {
        //
    }
}
