<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\Survey;
use App\Http\Resources\SurveyQuestionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SurveyResource extends JsonResource
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
            'user_id' => $this->user_id,
            'title' => $this->title,
            'description' => $this->description,
            'slug' => $this->slug,
            'score' => $this->score,
            'submitted' => $this->submitted,
            'image' => env('APP_URL') . '/' . $this->image,
            'expire_date' => $this->expire_date,
            'created_at' => $this->created_at->format('d.m.Y'),
            'author' => User::where('id', $this->user_id)->get(),
            'questions' => SurveyQuestionResource::collection($this->questions)
        ];
    }
}