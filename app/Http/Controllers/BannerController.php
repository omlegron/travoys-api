<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Http\Resources\Banner as BannerResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $banners = Banner::query();

        if ($request->all != "true") {
            $banners = $banners->where('is_active', true);
        }

        $banners = $banners->orderBy('created_at', 'DESC')->get();

        return BannerResource::collection($banners);
    }

    public function validateBanner($request)
    {
        $request->validate([
            'image'   => 'required',
            'is_active'   => 'required|boolean',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateBanner($request);

        $image = $request->image;
        $imageType = explode('/', substr($image, 0, strpos($image, ';')))[1];
        $imageBase64 = str_replace('data:image/' . $imageType . ';base64,', '', $image);
        $imageName = str_random(32) . '.' . $imageType;
        Storage::put('public/images/banners/' . $imageName, base64_decode($imageBase64));

        $file = config('filesystems.disks.public.url') . '/images/banners/' . $imageName;

        $banner = Banner::create([
            'image' => $file,
            'link' => $request->link,
            'is_active' => $request->is_active,
        ]);

        return new BannerResource($banner);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        $this->validateBanner($request);

        Storage::delete('public/images/banners/' . basename($banner->image));

        $image = $request->image;

        $imageType = explode('/', substr($image, 0, strpos($image, ';')))[1];
        $imageBase64 = str_replace('data:image/' . $imageType . ';base64,', '', $image);
        $imageName = str_random(32) . '.' . $imageType;
        Storage::put('public/images/banners/' . $imageName, base64_decode($imageBase64));

        $file = config('filesystems.disks.public.url') . '/images/banners/' . $imageName;

        $banner->update([
            'image' => $file,
            'link' => $request->link,
            'is_active' => $request->is_active
        ]);

        return new BannerResource($banner);
    }

    public function changeStatus(Request $request, Banner $banner)
    {
        $request->validate([
            'is_active'   => 'required|boolean',
        ]);

        $banner->update([
            'is_active' => $request->is_active
        ]);

        return new BannerResource($banner);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();

        return response()->json([
            'data' => [
                'type' => 'banner_delete',
                'attributes' => [
                    'message' => 'Successfully deleted banner',
                ],
            ],
        ]);
    }
}
