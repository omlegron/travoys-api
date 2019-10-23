<?php

namespace App\Http\Controllers;

use App\TripPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Http\Resources\TripPlanAgeDemography;

class LiveRadioVisitorController extends Controller
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
    public function statistic()
    {
        $counter = Redis::hgetall('radio-listener:age');

        $ages = collect();
        foreach ($counter as $age => $count) {
            $ages->push([
                "age" => $age,
                "count" => (int) $count,
            ]);
        }

        return TripPlanAgeDemography::collection($ages->sortBy('age'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function increment(Request $request)
    {
        $tripPlan = TripPlan::where('user_id', $request->user()->id)
            ->latest()
            ->firstOrFail();

        Redis::hincrby('radio-listener:age', $tripPlan->age, 1);

        return response()->json([
            'data' => [
                'type' => 'radio-counter',
                'attributes' => [
                    'message' => 'User marked as active listener.',
                ],
            ],
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function decrement(Request $request)
    {
        $tripPlan = TripPlan::where('user_id', $request->user()->id)
            ->latest()
            ->firstOrFail();

        $count = Redis::hget('radio-listener:age', $tripPlan->age);

        if (filled($count) && $count > 0) {
            $visits = Redis::hincrby('radio-listener:age', $tripPlan->age, -1);
        }

        return response()->json([
            'data' => [
                'type' => 'radio-counter',
                'attributes' => [
                    'message' => 'User removed from active listener.',
                ],
            ],
        ]);
    }
}
