<?php

namespace App\Http\Controllers;

use App\FeedbackCategory;
use Illuminate\Http\Request;
use App\Http\Resources\FeedbackCategory as FeedbackCategoryResource;

class FeedbackCategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = FeedbackCategory::paginate();

        return FeedbackCategoryResource::collection($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FeedbackCategory  $feedbackCategory
     * @return \Illuminate\Http\Response
     */
    public function show(FeedbackCategory $feedbackCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FeedbackCategory  $feedbackCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(FeedbackCategory $feedbackCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FeedbackCategory  $feedbackCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FeedbackCategory $feedbackCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FeedbackCategory  $feedbackCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(FeedbackCategory $feedbackCategory)
    {
        //
    }
}
