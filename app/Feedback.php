<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id', 'feedback',
    ];

    /**
     * Get the author who wrote the feedback.
     */
    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Get the category of the feedback.
     */
    public function category()
    {
        return $this->belongsTo('App\FeedbackCategory', 'category_id');
    }
}
