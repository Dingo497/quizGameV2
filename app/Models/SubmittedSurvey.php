<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmittedSurvey extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'survey_id', 'author_user_id', 'achieved_score', 'total_score', 'achieved_score_in_percent'];

    /**
     * Get the survey of submitted survey.
     */
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    /**
     * Get the user of submitted survey.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
