<?php

namespace App\Http\Controllers;

use App\RestArea;
use App\Http\Resources\ParkingSlot as ParkingSlotResource;
use Illuminate\Http\Request;

class ParkingSlotController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(RestArea $rest_area)
    {
        $this->authorize('view', $rest_area);

        $parking_slot = $rest_area->parkingSlot;

        return new ParkingSlotResource($parking_slot);
    }

    public function validateStatus($request)
    {
        $this->validate($request, [
            'status' => 'required|in:kosong,ramai,penuh',
        ]);
    }

    public function status(RestArea $rest_area)
    {
        $this->authorize('view', $rest_area);

        $parking_slot = $rest_area->parkingSlot;

        $ratio = $parking_slot->used_slots / $parking_slot->slots;

        if ($ratio <= 2 / 5) {
            $status = "Kosong";
        } else if ($ratio > 2 / 5 && $ratio <= 4.5 / 5) {
            $status = "Ramai";
        } else {
            $status = "Penuh";
        }

        return response()->json([
            'type' => 'parking_slot_status',
            'id' => $parking_slot->id,
            'attributes' => [
                'status' => $status,
            ]
        ], 200);
    }

    public function changeStatus(Request $request, RestArea $rest_area)
    {
        $this->authorize('update', $rest_area);

        $this->validateStatus($request);

        $used_slots = 0;
        $status = $request->status;

        if ($status == "ramai") {
            $used_slots = ($rest_area->parkingSlot->slots * 2 / 5) + 1;
        } else if ($status == "penuh") {
            $used_slots = ($rest_area->parkingSlot->slots * 4.5 / 5) + 1;
        }

        $rest_area->parkingSlot()->update([
            'used_slots' => $used_slots
        ]);

        return response()->json([
            'type' => 'parking_slot_status',
            'id' => $rest_area->parkingSlot->id,
            'attributes' => [
                'status' => ucfirst($status),
            ]
        ], 200);
    }

    public function increaseUsedSlots(RestArea $rest_area)
    {
        $this->authorize('update', $rest_area);

        $parking_slot = $rest_area->parkingSlot;

        if ($parking_slot->used_slots == $parking_slot->slots) {
            return response()->json(['error' => 'Used parking slots already at the maximum value.'], 403);
        }

        $parking_slot->increment('used_slots');

        return new ParkingSlotResource($parking_slot);
    }

    public function decreaseUsedSlots(RestArea $rest_area)
    {
        $this->authorize('update', $rest_area);

        $parking_slot = $rest_area->parkingSlot;

        if (!$parking_slot->used_slots) {
            return response()->json(['error' => 'Used parking slots already at the minimum value.'], 403);
        }

        $parking_slot->decrement('used_slots');

        return new ParkingSlotResource($parking_slot);
    }
}
