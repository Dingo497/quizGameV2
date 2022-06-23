<?php

namespace App\Http\Resources;

use App\Http\Resources\QuestionAnswerResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SurveyQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type,
            'score' => $this->score,
            'survey_id' => $this->survey_id,
            'answers' => QuestionAnswerResource::collection($this->answers),
            'created_at' => $this->created_at->format('d.m.Y'),
        ];
    }
}