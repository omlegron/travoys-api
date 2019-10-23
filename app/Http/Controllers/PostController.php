<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Resources\LivePost\ListPost as ListPostResource;
use App\Http\Resources\LivePost\RetrievePost as RetrievePostResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
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
        $queryset = Post::with('user', 'comment');

        if ($request->search) {
            $queryset = $queryset->where('location',  'LIKE', '%' . $request->search . '%')
                ->orWhere('post',  'LIKE', '%' . $request->search . '%');
        }
        return ListPostResource::collection($queryset
                ->orderBy('created_at', 'desc')
                ->paginate(25)
                ->appends($request->query())
        );
    }

    public function validatePost($request)
    {
        $request->validate([
            'longitude'   => 'required|numeric',
            'latitude'   => 'required|numeric',
            'location'   => 'required',
            'post'   => 'required',
            'nomor_km'   => 'required|numeric',
            'image'   => 'required',
        ]);
    }

    public function store(Request $request)
    {
        $this->validatePost($request);

        $image = $request->image;
        $imageType = explode('/', substr($image, 0, strpos($image, ';')))[1];
        $imageBase64 = str_replace('data:image/' . $imageType . ';base64,', '', $image);
        $imageName = str_random(32) . '.' . $imageType;
        Storage::put('public/images/posts/' . $imageName, base64_decode($imageBase64));

        $file = config('filesystems.disks.public.url') . '/images/posts/' . $imageName;

        $post = Post::create([
            'user_id' => $request->user()->id,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'location' => $request->location,
            'post' => $request->post,
            'nomor_km' => $request->nomor_km,
            'image' => $file,
        ]);

        return new RetrievePostResource($post);
    }

    public function show(Post $post)
    {
        return new RetrievePostResource($post);
    }

    public function update(Request $request, Post $post)
    {
        $this->validatePost($request);

        Storage::delete('public/images/posts/' . basename($post->image));

        $image = $request->image;

        $imageType = explode('/', substr($image, 0, strpos($image, ';')))[1];
        $imageBase64 = str_replace('data:image/' . $imageType . ';base64,', '', $image);
        $imageName = str_random(32) . '.' . $imageType;
        Storage::put('public/images/posts/' . $imageName, base64_decode($imageBase64));

        $file = config('filesystems.disks.public.url') . '/images/posts/' . $imageName;

        $post->update([
            'user_id' => $request->user()->id,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'location' => $request->location,
            'post' => $request->post,
            'nomor_km' => $request->nomor_km,
            'image' => $file,
        ]);

        return new RetrievePostResource($post);
    }

    public function destroy(Request $request, Post $post)
    {
        if ($request->user()->id !== $post->user_id) {
            return response()->json(['error' => 'You can only delete your own posts.'], 403);
        }

        $post->delete();

        return response()->json([
            'data' => [
                'type' => 'live_post_delete',
                'attributes' => [
                    'message' => 'Successfully deleted post',
                ],
            ],
        ]);
    }
}
