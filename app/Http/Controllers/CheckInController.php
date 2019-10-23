<?php

namespace App\Http\Controllers;

use App\CheckIn;
use App\RestArea;
use App\Http\Resources\CheckIn\Details as CheckInDetailsResource;
use App\Http\Resources\CheckIn\History as CheckInHistoryResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Notifications\RestAreaCheckedIn;
use App\Notifications\RestAreaCheckedOut;
use App\Notifications\RestAreaReminder30;
use App\Notifications\RestAreaReminder60;
use App\Notifications\RestAreaReminder90;
use App\Notifications\RestAreaReminder100;
use App\Notifications\RestAreaReminder110;
use App\Notifications\YukMampirOnCheckedIn;

class CheckInController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function checkInHistory(Request $request)
    {
        $check_ins = CheckIn::where('user_id', $request->user()->id)
            ->whereNotNull('out')
            ->orderBy('in', 'DESC')
            ->get();

        foreach ($check_ins as $check_in) {
            $out = Carbon::parse($check_in->in);
            $in = Carbon::parse($check_in->out);
            $check_in->duration = $in->diffInSeconds($out);
        }

        return CheckInHistoryResource::collection($check_ins);
    }

    public function checkIn(Request $request, RestArea $rest_area)
    {
        $last_check_in = CheckIn::where('user_id', $request->user()->id)
            ->where('rest_area_id', $rest_area->id)
            ->whereNull('out')
            ->first();

        if ($last_check_in) {
            return response()->json([
                'error' => 'You still have unchecked out Rest Area.',
                'data' => [
                    new CheckInDetailsResource($last_check_in)
                ],
            ], 403);
        }

        $check_in = CheckIn::create([
            'user_id' => $request->user()->id,
            'rest_area_id' => $rest_area->id,
            'in' => Carbon::now()->toDateTimeString()
        ]);

        $request->user()->notify(new YukMampirOnCheckedIn());
        $request->user()->notify(new RestAreaCheckedIn($rest_area));
        $request->user()->notify(new RestAreaReminder30($rest_area, $check_in));
        $request->user()->notify(new RestAreaReminder60($rest_area, $check_in));
        $request->user()->notify(new RestAreaReminder90($rest_area, $check_in));
        $request->user()->notify(new RestAreaReminder100($rest_area, $check_in));
        $request->user()->notify(new RestAreaReminder110($rest_area, $check_in));

        return response()->json([
            'message' => 'Successfully checked in.',
            'data' => [
                new CheckInDetailsResource($check_in)
            ],
        ]);
    }

    public function checkOut(Request $request, RestArea $rest_area)
    {
        $last_check_in = CheckIn::where('user_id', $request->user()->id)
            ->where('rest_area_id', $rest_area->id)
            ->whereNull('out')
            ->first();

        if (!$last_check_in) {
            return response()->json([
                'error' => 'You already checked out or haven`t checked in to this Rest Area.'
            ], 403);
        }

        $last_check_in->update([
            'out' => Carbon::now()->toDateTimeString()
        ]);

        $rest_duration = $last_check_in->out->diffInMinutes($last_check_in->in);
        if ($rest_duration > 2 && $rest_duration < 120) {
            $request->user()->travAccount->restInTime();
        }

        $request->user()->notify(new RestAreaCheckedOut($rest_area));

        return response()->json([
            'message' => 'Successfully checked out.',
            'data' => [
                new CheckInDetailsResource($last_check_in)
            ],
        ]);
    }
}
