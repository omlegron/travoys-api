<?php

namespace App\Http\Controllers;

use App\Place;
use Illuminate\Http\Request;
use App\Http\Resources\PlaceCollection;
use App\Http\Resources\Place as PlaceResource;

class PlaceController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $places = Place::orderBy('name', 'asc');;

        if ($request->has('category')) {
            $places = $places->where('category_id', "{$request['category']}");
        }

        if ($request->has('query')) {
            $places = $places->where('name', 'LIKE', "%{$request['query']}%");
        }

        if ($request->has('has-photo') || $request['has-photo'] == "true") {
            $places = $places->whereNotNull('photo_url');
        }

        if (!$request->has('paginate') || $request['paginate'] == "true") {
            $places = $places->paginate()
                ->appends($request->query());
        } else {
            $places = $places->get();
        }

        return new PlaceCollection($places);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function indexNearby(Request $request)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $places = Place::hasCoordinates()
            ->distance($request->latitude, $request->longitude)
            ->orderBy('distance', 'ASC');

        if ($request->has('category')) {
            $places = $places->where('category_id', "{$request['category']}");
        }

        if ($request->has('query')) {
            $places = $places->where('name', 'LIKE', "%{$request['query']}%");
        }

        if ($request->has('has-photo') || $request['has-photo'] == "true") {
            $places = $places->whereNotNull('photo_url');
        }

        if (!$request->has('paginate') || $request['paginate'] == "true") {
            $places = $places->paginate()
                ->appends($request->query());
        } else {
            $places = $places->get();
        }

        return new PlaceCollection($places);
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
        return new PlaceResource($place);
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
