<?php

namespace App\Http\Controllers;

use App\PlaceCategory;
use App\Http\Resources\PlaceCategory as PlaceCategoryResource;
use Illuminate\Http\Request;

class PlaceCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');

        $this->authorizeResource(PlaceCategory::class, 'category');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('list', PlaceCategory::class);

        return PlaceCategoryResource::collection(PlaceCategory::orderBy('name', "ASC")->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        if (PlaceCategory::where('name', $request->name)->first()) {
            return response()->json(["error" => "Category already exist."], 403);
        }

        $category = PlaceCategory::create([
            'name' => $request->name
        ]);

        return new PlaceCategoryResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PlaceCategory $category)
    {
        return new PlaceCategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PlaceCategory $category)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        if (PlaceCategory::where('name', $request->name)->first()) {
            return response()->json(["error" => "Category already exist."], 403);
        }

        $category->update([
            'name' => $request->name
        ]);

        return new PlaceCategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlaceCategory $category)
    {
        $category->delete();

        return response()->json([
            'data' => [
                'type' => 'place_category_delete',
                'attributes' => [
                    'message' => 'Successfully deleted place category',
                ],
            ],
        ]);
    }
}
