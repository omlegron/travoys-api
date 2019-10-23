<?php

namespace App\Http\Controllers;

use App\RestArea;
use App\Http\Resources\RestAreaItem;
use Illuminate\Http\Request;

class FuelController extends Controller
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

    public function show(RestArea $rest_area)
    {
        $this->authorize('view', $rest_area);

        $fuel = $rest_area->fuel;

        return response()->json([
            'type' => 'rest_area_fuel_status',
            'id' => $fuel->id,
            'attributes' => [
                'rest-area' => new RestAreaItem($rest_area),
                'pertalite' => $fuel->pertalite,
                'pertamax' => $fuel->pertamax,
                'pertamax_plus' => $fuel->pertamax_plus,
                'dexlite' => $fuel->dexlite,
            ]
        ], 200);
    }

    public function validateStatus($request)
    {
        $this->validate($request, [
            'pertalite' => 'boolean',
            'pertamax' => 'boolean',
            'pertamax_plus' => 'boolean',
            'dexlite' => 'boolean',
        ]);
    }

    public function changeStatus(Request $request, RestArea $rest_area)
    {
        $this->authorize('update', $rest_area);

        $this->validateStatus($request);

        $rest_area->fuel()->update($request->all());

        $fuel = $rest_area->fuel;

        return response()->json([
            'type' => 'rest_area_fuel_status',
            'id' => $fuel->id,
            'attributes' => [
                'rest-area' => new RestAreaItem($rest_area),
                'pertalite' => $fuel->pertalite,
                'pertamax' => $fuel->pertamax,
                'pertamax_plus' => $fuel->pertamax_plus,
                'dexlite' => $fuel->dexlite,
            ]
        ], 200);
    }
}
