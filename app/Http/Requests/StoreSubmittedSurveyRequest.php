<?php

namespace App\Http\Requests;

use App\Rules\StringOrArray;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreSubmittedSurveyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::check()) {
            return true;
        }
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => Auth::id(),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user_id' => 'required|integer',
            'survey_id' => 'required|integer',
            'author_user_id' => 'required|integer',
            'total_score' => 'required|integer',
            'answers' => 'required|array',
            'answers.*.0.id' => 'required|integer',
            'answers.*.0.value' => ['required', new StringOrArray]
        ];
    }
}
