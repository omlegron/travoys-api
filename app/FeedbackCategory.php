<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedbackCategory extends Model
{
    /**
     * Get feedback in the category.
     */
    public function feedback()
    {
        return $this->hasMany('App\Feedback');
    }
}
