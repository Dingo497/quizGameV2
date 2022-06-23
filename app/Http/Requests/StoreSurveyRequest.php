<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreSurveyRequest extends FormRequest
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
            'slug' => Str::slug($this->title),
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
            'slug' => 'required|string|unique:surveys',
            'title' => 'required|string|unique:surveys|max:1000',
            'image' => 'nullable|string',
            'score' => 'required|integer',
            'user_id' => 'required|integer',
            'description' => 'nullable|string',
            'expire_date' => 'nullable|date|after:tomorrow',
            'questions.*.type' => 'required|string',
            'questions.*.title' => 'required|string|max:1000',
            'questions.*.description' => 'nullable|string',
            'questions.*.score' => 'required|integer',
            'questions.*.options.*.text' => 'required|string|max:400',
            'questions.*.options.*.correctAnswer' => 'required|boolean',
        ];
    }
}
