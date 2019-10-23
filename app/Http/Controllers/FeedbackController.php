<?php

namespace App\Http\Controllers;

use App\Feedback;
use Illuminate\Http\Request;
use App\Http\Resources\FeedbackCollection;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Feedback as FeedbackResource;

class FeedbackController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');

        $this->authorizeResource(Feedback::class, 'feedback');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('list', Feedback::class);

        $feedback = Feedback::query();

        if ($request->has('category')) {
            $feedback = $feedback->where('category_id', "{$request['category']}");
        }

        if ($request->has('query')) {
            $feedback = $feedback->where('feedback', 'LIKE', "%{$request['query']}%");
        }

        if (!$request->has('paginate') || $request['paginate'] == "true") {
            $feedback = $feedback->paginate()
                ->appends($request->query());
        } else {
            $feedback = $feedback->get();
        }

        return (new FeedbackCollection($feedback));
    }

    /**
     * Display a listing of the resource authored by current user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function indexMine(Request $request)
    {
        return (new FeedbackCollection($request->user()->feedback()->paginate()))
            ->additional(['included' => [
                new UserResource($request->user()),
            ]]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'feedback' => 'required',
        ]);

        $feedback = $request->user()->feedback()->create([
            'feedback' => $request->feedback,
            'category_id' => $request->category,
        ]);

        return (new FeedbackResource($feedback))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function show(Feedback $feedback)
    {
        return new FeedbackResource($feedback);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feedback $feedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feedback $feedback)
    {
        //
    }
}
