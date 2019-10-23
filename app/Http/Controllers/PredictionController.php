<?php

namespace App\Http\Controllers;

use DB;
use App\TripPlan;
use Illuminate\Http\Request;
use App\Http\Resources\Prediction as PredictionResource;

class PredictionController extends Controller
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

    public function validateDate($request)
    {
        $request->validate([
            'date_start'   => 'date',
            'date_end'   => 'date|after:date_start',
        ]);
    }

    public function validateTime($request)
    {
        $this->validate($request, [
            'time_start' => 'date_format:H',
            'time_end' => 'date_format:H|after:time_start',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getByDate(Request $request)
    {
        $queryset = TripPlan::groupBy('datetime')
            ->orderBy('datetime', 'ASC')
            ->get(array(
                DB::raw('DATE(departure_date) as datetime'),
                DB::raw('SUM(total_passenger) as "total_travelers"'),
                DB::raw('COUNT(*) as "total_vehicles"'),
            ));

        if ($request->date_start && $request->date_end) {
            $this->validateDate($request);

            $queryset = $queryset->whereBetween(
                'datetime',
                [$request->date_start, $request->date_end]
            );
        }

        $request->type = "date";

        return PredictionResource::collection($queryset);
    }

    public function getByTime(Request $request)
    {
        $trip_plan = new TripPlan();

        if ($request->date_start && $request->date_end) {
            $this->validateDate($request);

            $trip_plan = $trip_plan->whereBetween(
                'departure_date',
                [$request->date_start . " 00:00:00", $request->date_end . " 23:59:59"]
            );
        }

        $queryset = $trip_plan->groupBy('datetime')
            ->orderBy('datetime', 'ASC')
            ->get(array(
                DB::raw('HOUR(departure_date) as datetime'),
                DB::raw('SUM(total_passenger) as "total_travelers"'),
                DB::raw('COUNT(*) as "total_vehicles"'),
            ));

        if ($request->time_start && $request->time_end) {
            $this->validateTime($request);

            $queryset = $queryset->whereBetween(
                'datetime',
                [$request->time_start, $request->time_end]
            );
        }

        $request->type = "time";

        return PredictionResource::collection($queryset);
    }
}
