<?php

namespace App\Http\Controllers\Api;

use App\RestArea;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RestAreaCollection;
use App\Http\Resources\RestAreaItem;
use Illuminate\Support\Facades\Storage;

class RestAreaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');

        $this->authorizeResource(RestArea::class, 'rest_area');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('list', RestArea::class);

        $restAreas = RestArea::query();

        if ($request->has('route')) {
            $restAreas = $restAreas->where('route', $request['route']);
        }

        if ($request->has('query')) {
            $searchQuery = $request['query'];
            $restAreas = $restAreas->where(function ($query) use ($searchQuery) {
                $query->where('name', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('route', 'LIKE', "%{$searchQuery}%");
            });
        }

        $restAreas = $restAreas
            ->orderByRaw('LENGTH(name) ASC')
            ->orderBy('name', 'ASC');

        if (!$request->has('paginate') || $request['paginate'] == "true") {
            $restAreas = $restAreas->paginate(10)
                ->appends($request->query());
        } else {
            $restAreas = $restAreas->get();
        }

        return new RestAreaCollection($restAreas);
    }

    /**
     * Display a listing of the nearby resource.
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

        $restAreas = RestArea::distance($request->latitude, $request->longitude);

        if ($request->has('route')) {
            $restAreas = $restAreas->where('route', $request['route']);
        }

        $restAreas = $restAreas->orderBy('distance', 'ASC');

        if (!$request->has('paginate') || $request['paginate'] == "true") {
            $restAreas = $restAreas->paginate(10)
                ->appends($request->query());
        } else {
            $restAreas = $restAreas->get();
        }

        return new RestAreaCollection($restAreas);
    }

    public function validateRestArea($request)
    {
        $request->validate([
            'image'   => 'required',
            'name'   => 'required|string',
            'longitude'   => 'required|numeric',
            'latitude'   => 'required|numeric',
            'highway_id'   => 'required|numeric',
            'parking_slots'   => 'required|numeric',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateRestArea($request);

        $image = $request->image;
        $imageType = explode('/', substr($image, 0, strpos($image, ';')))[1];
        $imageBase64 = str_replace('data:image/' . $imageType . ';base64,', '', $image);
        $imageName = str_random(32) . '.' . $imageType;
        Storage::put('public/images/rest-areas/' . $imageName, base64_decode($imageBase64));

        $file = config('filesystems.disks.public.url') . '/images/rest-areas/' . $imageName;

        $restArea = RestArea::create([
            'image' => $file,
            'name' => $request->name,
            'route' => $request->route,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'highway_id' => $request->highway_id,
        ]);

        $restArea->parkingSlot()->create([
            'slots' => $request->parking_slots
        ]);

        $restArea->fuel()->create();

        return new RestAreaItem($restArea);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RestArea  $restArea
     * @return \Illuminate\Http\Response
     */
    public function show(RestArea $restArea)
    {
        return $restArea->with('places')->findOrFail($restArea->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RestArea  $restArea
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RestArea $restArea)
    {
        $this->validateRestArea($request);

        Storage::delete('public/images/rest-areas/' . basename($restArea->image));

        $image = $request->image;
        $imageType = explode('/', substr($image, 0, strpos($image, ';')))[1];
        $imageBase64 = str_replace('data:image/' . $imageType . ';base64,', '', $image);
        $imageName = str_random(32) . '.' . $imageType;
        Storage::put('public/images/rest-areas/' . $imageName, base64_decode($imageBase64));

        $file = config('filesystems.disks.public.url') . '/images/rest-areas/' . $imageName;

        $restArea->update([
            'image' => $file,
            'name' => $request->name,
            'route' => $request->route,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'highway_id' => $request->highway_id,
        ]);

        $restArea->parkingSlot()->update([
            'slots' => $request->parking_slots
        ]);

        return new RestAreaItem($restArea);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RestArea  $restArea
     * @return \Illuminate\Http\Response
     */
    public function destroy(RestArea $restArea)
    {
        $restArea->parkingSlot()->delete();
        $restArea->places()->delete();
        $restArea->fuel()->delete();
        $restArea->delete();

        return response()->json([
            'data' => [
                'type' => 'rest_area_delete',
                'attributes' => [
                    'message' => 'Successfully deleted rest area',
                ],
            ],
        ]);
    }
}
