<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use Illuminate\Http\Request;
use App\Notifications\CommentPosted;
use App\Http\Resources\LivePost\Comment as CommentResource;

class CommentController extends Controller
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
        //
    }

    public function validateComment($request)
    {
        $request->validate([
            'comment'   => 'required',
        ]);
    }

    public function store(Request $request, Post $post)
    {
        $this->validateComment($request);

        $comment = Comment::create([
            'user_id' => $request->user()->id,
            'post_id' => $post->id,
            'comment' => $request->comment,
        ]);

        $post->user->notify(new CommentPosted($comment));

        return (new CommentResource($comment))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Comment $comment)
    {
        //
    }

    public function update(Request $request, Post $post, Comment $comment)
    {
        if ($request->user()->id !== $comment->user_id) {
            return response()->json(['error' => 'You can only edit your own comments.'], 403);
        }

        $this->validateComment($request);
        $comment->update($request->only('comment'));

        return (new CommentResource($comment))
            ->response()
            ->setStatusCode(200);
    }

    public function destroy(Request $request, Post $post, Comment $comment)
    {
        if ($request->user()->id !== $comment->user_id) {
            return response()->json(['error' => 'You can only delete your own comments.'], 403);
        }

        $comment->delete();

        return response()->json([
            'data' => [
                'type' => 'comment_delete',
                'attributes' => [
                    'message' => 'Successfully deleted comment',
                ],
            ],
        ]);
    }
}
