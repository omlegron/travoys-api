<?php

namespace App\Http\Controllers;

use App\City;
use App\Place;
use Illuminate\Http\Request;
use App\Http\Resources\PlaceCollection;
use App\Http\Resources\City as CityResource;

class CityPlaceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, City $city)
    {
        $places = $city->places();

        if ($request->has('category')) {
            $places = $places->where('category_id', "{$request['category']}");
        }

        if ($request->has('query')) {
            $places = $places->where('name', 'LIKE', "%{$request['query']}%");
        }

        $places = $places
            ->orderBy('name', 'asc')
            ->paginate()
            ->appends($request->query());

        return (new PlaceCollection($places))
            ->additional(['included' => [
                new CityResource($city),
            ]]);
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
     * @param  \App\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function show(Place $place)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Place $place)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy(Place $place)
    {
        //
    }
}
