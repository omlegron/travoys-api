<?php

namespace App\Http\Controllers;

use App\TripPlan;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\TripPlanAgeDemography;

class TripPlanDemographyController extends Controller
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
    public function age()
    {
        $ages = TripPlan::groupBy('age')
            ->orderBy('age', 'ASC')
            ->get(DB::raw('age, count(*) as count'));

        return TripPlanAgeDemography::collection($ages);
    }
}
