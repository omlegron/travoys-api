<?php

namespace App\Http\Controllers\Api;

use App\VehicleClass;
use Illuminate\Http\Request;
use App\Http\Resources\VehicleClassCollection;
use App\Http\Resources\VehicleClassItem;
use App\Http\Controllers\Controller;

class VehicleClassController extends Controller
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
        return new VehicleClassCollection(VehicleClass::get());
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
        $this->validate($request, VehicleClass::rules(false));
        $data = VehicleClass::create($request->all());
        if (!$data) {
            return [
                'message' => 'Bad Request',
                'code' => 400,
            ];
        } else {
            return [
                'message' => 'Created',
                'code' => 201,
                'data' => $data,
            ];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VehicleClass  $vehicleClass
     * @return \Illuminate\Http\Response
     */
    public function show(VehicleClass $vehicleClass)
    {
        return new VehicleClassItem($vehicleClass);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VehicleClass  $vehicleClass
     * @return \Illuminate\Http\Response
     */
    public function edit(VehicleClass $vehicleClass)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VehicleClass  $vehicleClass
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VehicleClass $vehicleClass)
    {
        $this->validate($request, VehicleClass::rules(true, $vehicleClass->id));
        $data = $vehicleClass->update($request->all());
        if (!$data) {
            return [
                'message' => 'Bad Request',
                'code' => 400,
            ];
        } else {
            return [
                'message' => 'Updated',
                'code' => 201,
                'data' => $vehicleClass,
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VehicleClass  $vehicleClass
     * @return \Illuminate\Http\Response
     */
    public function destroy(VehicleClass $vehicleClass)
    {
        if ($vehicleClass->delete()) {
            return [
                'message' => 'Deleted',
                'code' => 204,
            ];
        } else {
            return [
                'message' => 'Bad Request',
                'code' => 400,
            ];
        }

    }
}
