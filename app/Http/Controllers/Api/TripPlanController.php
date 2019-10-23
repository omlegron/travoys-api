<?php

namespace App\Http\Controllers\Api;

use App\TripPlan;
use Illuminate\Http\Request;
use App\Http\Resources\TripPlanCollection;
use App\Http\Resources\TripPlanItem;
use App\Http\Controllers\Controller;

class TripPlanController extends Controller
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
    public function index(Request $request)
    {
        return TripPlan::with('user')->where('user_id', $request->user()->id)->orderBy('created_at', 'desc')->first();
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
        $this->validate($request, TripPlan::rules(false));
        $data = TripPlan::create([
            'user_id' => $request->user()->id,
            'start_location_name' => $request->start_location_name,
            'start_location_latitude' => $request->start_location_latitude,
            'start_location_longitude' => $request->start_location_longitude,
            'final_location_name' => $request->final_location_name,
            'final_location_latitude' => $request->final_location_latitude,
            'final_location_longitude' => $request->final_location_longitude,
            'departure_date' => $request->departure_date,
            'age' => $request->age,
            'total_passenger' => $request->total_passenger,
            'vehicle_class_id' => $request->vehicle_class_id,
            'number_plate' => $request->number_plate,
            'passenger_type' => $request->passenger_type,
        ]);
        if (!$data) {
            return [
                'message' => 'Bad Request',
                'code' => 400,
            ];
        } else {
            $request->user()->travAccount->fillTripPlan();

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
     * @param  \App\TripPlan  $TripPlan
     * @return \Illuminate\Http\Response
     */
    public function show(TripPlan $tripPlan)
    {
        return new TripPlanItem($tripPlan);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TripPlan  $TripPlan
     * @return \Illuminate\Http\Response
     */
    public function edit(TripPlan $tripPlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TripPlan  $TripPlan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TripPlan $tripPlan)
    {
        $this->validate($request, TripPlan::rules(true, $tripPlan->id));
        $data = $tripPlan->update($request->all());
        if (!$data) {
            return [
                'message' => 'Bad Request',
                'code' => 400,
            ];
        } else {
            return [
                'message' => 'Updated',
                'code' => 201,
                'data' => $tripPlan,
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TripPlan  $TripPlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(TripPlan $tripPlan)
    {
        if ($tripPlan->delete()) {
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
