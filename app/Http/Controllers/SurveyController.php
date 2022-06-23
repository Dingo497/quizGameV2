<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Support\Str;
use App\Models\SurveyQuestion;
use Illuminate\Support\Facades\File;
use App\Http\Resources\SurveyResource;
use App\Http\Resources\SurveyCollection;
use App\Http\Requests\StoreSurveyRequest;
use App\Http\Requests\UpdateSurveyRequest;
use App\Models\QuestionAnswer;

class SurveyController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return new SurveyCollection(Survey::all());
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\StoreSurveyRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreSurveyRequest $request)
	{
		$survey = $request->validated();

		// isset image save it and store in DB his path to img
		if (isset($survey['image'])) {
			$relativePath  = $this->saveImage($survey['image']);
			$survey['image'] = $relativePath;
		}

		// prepare questions array for store
		$questions = $survey['questions'];
		unset($survey['questions']);

		// gradually saving data
		$newSurvey = Survey::create($survey);
		foreach($questions as $key => $value) {
			$questions[$key]['survey_id'] = $newSurvey['id'];
			$newQuestion = SurveyQuestion::create($questions[$key]);
			
			if(!empty($value['options'])) {
				foreach($value['options'] as $keyOptions => $valueOptions ) {
					$value['options'][$keyOptions]['survey_question_id'] = $newQuestion['id'];
					QuestionAnswer::create($value['options'][$keyOptions]);
				}
			}
		}

		return new SurveyResource($newSurvey);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  String  $slug
	 * @return \Illuminate\Http\Response
	 */
	public function show(String $slug)
	{
		$survey = Survey::where('slug', $slug)->firstOrFail();
		return new SurveyResource($survey);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Survey  $survey
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Survey $survey)
	{
			//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\UpdateSurveyRequest  $request
	 * @param  \App\Models\Survey  $survey
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateSurveyRequest $request, Survey $survey)
	{
			//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Survey  $survey
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Survey $survey)
	{
			//
	}


	/**
	 * Save image in local file system and return saved image path
	 *
	 * @param $image
	 * @throws \Exception
	 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
	 */
	private function saveImage($image)
	{
		// Check if image is valid base64 string
		if (preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {
				// Take out the base64 encoded text without mime type
				$image = substr($image, strpos($image, ',') + 1);
				// Get file extension
				$type = strtolower($type[1]); // jpg, png, gif

				// Check if file is an image
				if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
						throw new \Exception('invalid image type');
				}
				$image = str_replace(' ', '+', $image);
				$image = base64_decode($image);

				if ($image === false) {
						throw new \Exception('base64_decode failed');
				}
		} else {
				throw new \Exception('did not match data URI with image data');
		}

		$dir = 'images/';
		$file = Str::random() . '.' . $type;
		$absolutePath = public_path($dir);
		$relativePath = $dir . $file;
		if (!File::exists($absolutePath)) {
				File::makeDirectory($absolutePath, 0755, true);
		}
		file_put_contents($relativePath, $image);

		return $relativePath;
	}
}
