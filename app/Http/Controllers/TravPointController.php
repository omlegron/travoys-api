<?php

namespace App\Http\Controllers;

use App\TravAccount;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\TravAccount as TravAccountResource;

class TravPointController extends Controller
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
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function account(Request $request)
    {
        return (new TravAccountResource($request->user()->travAccount))
            ->response();
    }

    /**
     * Set referral of current user.
     *
     * @return \Illuminate\Http\Response
     */
    public function setReferral(Request $request)
    {
        $request->validate([
            'code' => 'required|string|min:7|max:7',
        ]);

        $account = $request->user()->travAccount;

        if ($request->code == $account->code) {
            return response()->json([
                'errors' => [
                    'status' => '400',
                    'title' => 'Not Processing',
                    'detail' => 'You can\'t add yourself as referrer.',
                ],
            ], 400);
        }

        try {
            $account->setReferral($request->code);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'errors' => [
                    'status' => '404',
                    'title' => 'Invalid Code',
                    'detail' => 'Referral TravAccount doesn\'t exist.',
                ],
            ], 400);
        }

        return response()->json([
            'data' => [
                'type' => 'travpoints-referral',
                'attributes' => [
                    'message' => "$request->code has been noted as your referrer.",
                ],
            ],
        ]);
    }
}
