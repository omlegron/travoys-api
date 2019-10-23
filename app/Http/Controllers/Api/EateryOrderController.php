<?php

namespace App\Http\Controllers\Api;

use App\Eatery;
use App\EateryMenu;
use App\EateryOrder;
use App\EateryOrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EateryOrderCollection;
use App\Http\Resources\EateryOrderItem;
use App\Notifications\EateryOrderCreated;
use App\Notifications\EateryOrderIsReady;
use App\Notifications\EateryOrderCanceled;
use Illuminate\Support\Facades\Notification;

class EateryOrderController extends Controller
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
        return EateryOrder::with(['user', 'orders'])
                          ->where('user_id', $request->user()->id)
                          ->orderBy('created_at', 'desc')
                          ->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexSatgas(Request $request)
    {
        $rest_area_ids = $request->user()->satgasAt->pluck('id')->toArray();
        $eatery_ids = Eatery::whereIn('rest_area_id', $rest_area_ids)
            ->pluck('id')
            ->toArray();

        return EateryOrder::with(['user', 'orders'])
                          ->whereIn('eatery_id', $eatery_ids)
                          ->orderBy('created_at', 'desc')
                          ->get();
    }

    /**
     * Get Last Data.
     *
     * @return \Illuminate\Http\Response
     */
    public function recent(Request $request)
    {
        return EateryOrder::with(['user', 'orders'])
                          ->where('user_id', $request->user()->id)
                          ->orderBy('created_at', 'desc')
                          ->first();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->orders) {
            return [
                'message' => 'Order not found',
                'code' => 404,
            ];
        }
        $code = 'TR' . date('ymdhis') . $request->user()->id;

        $this->validate($request, EateryOrder::rules(false));
        $order = EateryOrder::create([
            'code' => $code,
            'user_id' => $request->user()->id,
            'eatery_id' => $request->eatery_id,
        ]);

        $total = 0;

        if (!$order) {
            return [
                'message' => 'Bad Request',
                'code' => 400,
            ];
        } else {
            foreach ($request->orders as $key => $item) {
                EateryOrderDetail::create([
                    'eatery_order_id' => $order->id,
                    'eatery_menu_id' => $item['eatery_menu_id'],
                    'count' => $item['count']
                ]);

                $total += EateryMenu::findOrFail($item['eatery_menu_id'])->price_for_sell * $item['count'];
            }

            $order->total = $total;
            $order->save();

            // Notification
            $satgas = Eatery::findOrFail($request->eatery_id)->restArea->satgas;
            Notification::send($satgas, new EateryOrderCreated($order));

            return EateryOrder::with(['user', 'orders'])
                                ->where('user_id', $request->user()->id)
                                ->orderBy('created_at', 'desc')
                                ->first();
        }
        
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EateryOrder  $eateryOrder
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $data = EateryOrder::with(['user', 'orders'])
                            ->where('id', $id)
                            ->where('user_id', $request->user()->id)
                            ->orderBy('created_at', 'desc')
                            ->first();
        if ($data) {
            return  $data;
        } else {
            return [
                'message' => 'Not Found',
                'code' => 404,
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EateryOrder  $eateryOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(EateryOrder $eateryOrder)
    {
        $detail = EateryOrderDetail::where('eatery_order_id', $eateryOrder->id)->delete();
        $order = $eateryOrder->delete();

        if ($detail && $order) {
            return [
                'message' => 'Succesfully Delete Order',
                'code' => 204,
            ];
        } else {
            return [
                'message' => 'Bad Request',
                'code' => 400,
            ];
        }
    }

    /**
     * Update Status for EateryOrder.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $data = EateryOrder::with(['user', 'orders'])
                            ->where('id', $id)
                            ->first();
        if ($request->status) {
            $data->status = $request->status;
            if ($data->status === 'ready') {
                $data->user->notify(new EateryOrderIsReady());
            } else if ($data->status === 'canceled') {
                $data->user->notify(new EateryOrderCanceled());
            } else if ($data->status === 'paid') {
                $data->paid_date = date('Y-m-d H:i:s');
            }
            $data->save();
            return $data;
        } else {
            return [
                'message' => 'Status not found',
                'code' => 404,
            ];
        }
    }
}
