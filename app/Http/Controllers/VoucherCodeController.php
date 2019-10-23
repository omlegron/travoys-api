<?php

namespace App\Http\Controllers;

use App\Voucher;
use App\VoucherCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\VoucherCode as VoucherCodeResource;

class VoucherCodeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');

        $this->authorizeResource(VoucherCode::class, 'code');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Voucher $voucher)
    {
        $this->authorize('list', VoucherCode::class);

        $codes = $voucher->codes();

        if ($request->is_available == "true") {
            $codes = $codes->available();
        }

        if ($request->is_valid == "true") {
            $codes = $codes->valid();
        }

        if (!$request->has('paginate') || $request['paginate'] == "true") {
            $codes = $codes->paginate()
                ->appends($request->query());
        } else {
            $codes = $codes->get();
        }

        return VoucherCodeResource::collection($codes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Voucher $voucher)
    {
        $this->validator($request->all())->validate();

        $code = $voucher->codes()->create([
            'code' => $request->code,
            'expired_at' => $request->expired_at,
        ]);

        return new VoucherCodeResource($code);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Voucher  $voucher
     * @param  \App\VoucherCode  $code
     * @return \Illuminate\Http\Response
     */
    public function show(Voucher $voucher, VoucherCode $code)
    {
        $voucherCode = $voucher->codes->find($code);

        return new VoucherCodeResource($voucherCode);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Voucher  $voucher
     * @param  \App\VoucherCode  $code
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Voucher $voucher, VoucherCode $code)
    {
        $this->validator($request->all())->validate();

        $voucher->codes()->findOrFail($code->id)->update([
            'code' => $request->code,
            'expired_at' => $request->expired_at,
        ]);

        return new VoucherCodeResource($code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Voucher  $voucher
     * @param  \App\VoucherCode  $code
     * @return \Illuminate\Http\Response
     */
    public function destroy(Voucher $voucher, VoucherCode $code)
    {
        $voucher->codes()->findOrFail($code->id)->delete();

        return response()->json([
            'data' => [
                'type' => 'voucher-codes-delete',
                'attributes' => [
                    'message' => 'Successfully deleted voucher code',
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
            'code' => ['required', 'string', 'max:255'],
            'expired_at' => ['required', 'date'],
        ]);
    }
}
