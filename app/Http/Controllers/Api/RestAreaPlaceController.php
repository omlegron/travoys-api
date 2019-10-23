<?php

namespace App\Http\Controllers\Api;

use App\RestArea;
use App\RestAreaPlace;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RestAreaPlaceCollection;
use App\Http\Resources\RestAreaPlace as RestAreaPlaceResource;
use App\Http\Resources\RestAreaItem as RestAreaResource;
use Illuminate\Support\Facades\Storage;

class RestAreaPlaceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');

        $this->authorizeResource(RestAreaPlace::class, 'place');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RestArea  $restArea
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, RestArea $restArea)
    {
        $this->authorize('list', RestAreaPlace::class);

        $places = $restArea->places();

        if ($request->has('type')) {
            $places = $places->where('rest_area_place_type_id', "{$request['type']}");
        }

        $places = $places
            ->orderBy('name', 'asc')
            ->paginate()
            ->appends($request->query());

        return (new RestAreaPlaceCollection($places))
            ->additional(['included' => [
                new RestAreaResource($restArea),
            ]]);
    }

    public function validateRestAreaPlace($request)
    {
        $request->validate([
            'image'   => 'required',
            'name'   => 'required|string',
            'rest_area_place_type_id'   => 'required|numeric',
            'longitude'   => 'required|numeric',
            'latitude'   => 'required|numeric',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RestArea  $restArea
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, RestArea $restArea)
    {
        $this->validateRestAreaPlace($request);

        $image = $request->image;
        $imageType = explode('/', substr($image, 0, strpos($image, ';')))[1];
        $imageBase64 = str_replace('data:image/' . $imageType . ';base64,', '', $image);
        $imageName = str_random(32) . '.' . $imageType;
        Storage::put('public/images/rest-areas/places/' . $imageName, base64_decode($imageBase64));

        $file = config('filesystems.disks.public.url') . '/images/rest-areas/places/' . $imageName;

        $place = RestAreaPlace::create([
            'image' => $file,
            'name' => $request->name,
            'rest_area_id' => $restArea->id,
            'rest_area_place_type_id' => $request->rest_area_place_type_id,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
        ]);

        return new RestAreaPlaceResource($place);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RestArea  $restArea
     * @param  \App\RestAreaPlace  $place
     * @return \Illuminate\Http\Response
     */
    public function show(RestArea $restArea, RestAreaPlace $place)
    {
        return $restArea->places()->with('facility')->findOrFail($place->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RestArea  $restArea
     * @param  \App\RestAreaPlace  $place
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RestArea $restArea, RestAreaPlace $place)
    {
        $this->validateRestAreaPlace($request);

        $place = $restArea->places()->findOrFail($place->id);

        $image = $request->image;
        $imageType = explode('/', substr($image, 0, strpos($image, ';')))[1];
        $imageBase64 = str_replace('data:image/' . $imageType . ';base64,', '', $image);
        $imageName = str_random(32) . '.' . $imageType;
        Storage::put('public/images/rest-areas/places/' . $imageName, base64_decode($imageBase64));

        $file = config('filesystems.disks.public.url') . '/images/rest-areas/places/' . $imageName;

        $place->update([
            'image' => $file,
            'name' => $request->name,
            'rest_area_id' => $restArea->id,
            'rest_area_place_type_id' => $request->rest_area_place_type_id,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
        ]);

        return new RestAreaPlaceResource($place);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RestArea  $restArea
     * @param  \App\RestAreaPlace  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy(RestArea $restArea, RestAreaPlace $place)
    {
        $restArea->places()->findOrFail($place->id)->delete();

        return response()->json([
            'data' => [
                'type' => 'rest_area_place_delete',
                'attributes' => [
                    'message' => 'Successfully deleted rest area place',
                ],
            ],
        ]);
    }
}
