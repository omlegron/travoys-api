<?php

namespace App\Http\Controllers;

use App\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\VoucherCollection;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\CouldNotSubtractTravPoint;
use App\Http\Resources\Voucher as VoucherResource;

class VoucherController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');

        $this->authorizeResource(Voucher::class, 'voucher');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('list', Voucher::class);

        $vouchers = Voucher::query();

        if ($request->has('only-available')) {
            $vouchers = $vouchers->available();
        }

        $vouchers = $vouchers
            ->paginate()
            ->appends($request->query());

        return new VoucherCollection($vouchers);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function redeem(Request $request, Voucher $voucher)
    {
        if ($request->user()->vouchers->contains($voucher)) {
            return response()->json([
                'errors' => [
                    'status' => '403',
                    'title' => 'Forbidden',
                    'detail' => "User has redeemed this voucher.",
                ],
            ], 400);
        }

        $voucher->redeemable = $voucher->codes()->valid()->available()->first();

        if (is_null($voucher->redeemable)) {
            return response()->json([
                'errors' => [
                    'status' => '404',
                    'title' => 'No Valid Voucher Code Available Found',
                    'detail' => "There's no valid & available voucher code for this voucher.",
                ],
            ], 404);
        }

        try {
            $request->user()->travAccount->redeem($voucher);
        } catch (CouldNotSubtractTravPoint $e) {
            return response()->json([
                'errors' => [
                    'status' => '400',
                    'title' => 'Insufficient TravPoint',
                    'detail' => "Could not subtract {$voucher->point} point.",
                ],
            ], 400);
        }

        $voucher->redeemable->redeemer_id = $request->user()->id;
        $voucher->redeemable->save();

        return new VoucherResource($voucher);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        $image = $request->image;
        $imageType = explode('/', substr($image, 0, strpos($image, ';')))[1];
        $imageBase64 = str_replace('data:image/' . $imageType . ';base64,', '', $image);
        $imageName = str_random(32) . '.' . $imageType;
        Storage::put('public/images/vouchers/' . $imageName, base64_decode($imageBase64));

        $file = config('filesystems.disks.public.url') . '/images/vouchers/' . $imageName;

        $voucher = Voucher::create([
            'name' => $request->name,
            'short_description' => $request->short_description,
            'point' => $request->point,
            'amount' => $request->amount,
            'image_url' => $file,
        ]);

        return new VoucherResource($voucher);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function show(Voucher $voucher)
    {
        return new VoucherResource($voucher);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Voucher $voucher)
    {
        $this->validator($request->all())->validate();

        Storage::delete('public/images/vouchers/' . basename($voucher->image));

        $image = $request->image;

        $imageType = explode('/', substr($image, 0, strpos($image, ';')))[1];
        $imageBase64 = str_replace('data:image/' . $imageType . ';base64,', '', $image);
        $imageName = str_random(32) . '.' . $imageType;
        Storage::put('public/images/vouchers/' . $imageName, base64_decode($imageBase64));

        $file = config('filesystems.disks.public.url') . '/images/vouchers/' . $imageName;

        $voucher->update([
            'name' => $request->name,
            'short_description' => $request->short_description,
            'point' => $request->point,
            'amount' => $request->amount,
            'image_url' => $file,
        ]);

        return new VoucherResource($voucher);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Voucher $voucher)
    {
        $voucher->delete();

        return response()->json([
            'data' => [
                'type' => 'vouchers-delete',
                'attributes' => [
                    'message' => 'Successfully deleted voucher',
                ],
            ],
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'short_description' => ['required', 'string', 'max:255'],
            'point' => ['required', 'integer'],
            'amount' => ['required', 'integer'],
            'image' => ['required'],
        ]);
    }
}
