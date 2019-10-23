<?php

namespace App\Http\Controllers;

use App\TollGate;
use App\Http\Resources\TollGate as TollGateResource;
use Illuminate\Http\Request;

class TollGateController extends Controller
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
    public function index()
    {
        $toll_gate = TollGate::orderBy('name', 'ASC')
            ->paginate(10);

        return TollGateResource::collection($toll_gate);
    }

    public function validateTollGate($request)
    {
        $request->validate([
            'name'   => 'required|string',
            'longitude'   => 'required|numeric',
            'latitude'   => 'required|numeric',
            'highway_id'   => 'numeric',
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
        $this->validateTollGate($request);

        $toll_gate = TollGate::create([
            'name' => $request->name,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'highway_id' => $request->highway_id,
        ]);

        return new TollGateResource($toll_gate);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(TollGate $toll_gate)
    {
        return new TollGateResource($toll_gate);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TollGate $toll_gate)
    {
        $this->validateTollGate($request);

        $toll_gate->update([
            'name' => $request->name,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'highway_id' => $request->highway_id,
        ]);

        return new TollGateResource($toll_gate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TollGate $toll_gate)
    {
        $toll_gate->delete();

        return response()->json([
            'data' => [
                'type' => 'toll_gate_delete',
                'attributes' => [
                    'message' => 'Successfully deleted toll gate',
                ],
            ],
        ]);
    }
}
