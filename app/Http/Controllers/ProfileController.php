<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
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
    public function show($id)
    {
        return new UserResource(User::find($id));
    }

    public function myProfile(Request $request)
    {
        return new UserResource($request->user());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateAvatar(Request $request)
    {
        $current_avatar = $request->user()->avatar;
        if ($current_avatar) {
            Storage::delete('public/images/avatars/' . basename($current_avatar));
        }

        $file = "";

        if ($request->avatar) {
            $image = $request->avatar;
            $imageType = explode('/', substr($image, 0, strpos($image, ';')))[1];
            $imageBase64 = str_replace('data:image/' . $imageType . ';base64,', '', $image);
            $imageName = str_random(32) . '.' . $imageType;

            Storage::put('public/images/avatars/' . $imageName, base64_decode($imageBase64));
            $file = config('filesystems.disks.public.url') . '/images/avatars/' . $imageName;
        }

        $request->user()->update([
            'avatar' => $file,
        ]);

        return response()->json([
            'data' => [
                'type' => 'profile_avatar_update',
                'attributes' => [
                    'message' => 'Successfully updated your avatar',
                ],
            ],
        ]);
    }

    public function updateName(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $request->user()->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'data' => [
                'type' => 'profile_name_update',
                'attributes' => [
                    'message' => 'Successfully updated your name',
                ],
            ],
        ]);
    }

    public function updateEmail(Request $request)
    {
        if ($request->email != $request->user()->email) {
            $request->validate([
                'email' => 'required|email|unique:users'
            ]);

            $request->user()->update([
                'email' => $request->email,
            ]);
        }

        return response()->json([
            'data' => [
                'type' => 'profile_email_update',
                'attributes' => [
                    'message' => 'Successfully updated your email',
                ],
            ],
        ]);
    }

    public function updatePhone(Request $request)
    {
        $request->validate([
            'phone' => 'required|phone:ID,mobile'
        ]);

        $request->user()->update([
            'phone' => $request->phone,
        ]);

        return response()->json([
            'data' => [
                'type' => 'profile_phone_update',
                'attributes' => [
                    'message' => 'Successfully updated your phone number',
                ],
            ],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
