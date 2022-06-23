<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Survey;
use App\Models\SurveyQuestion;
use App\Models\SubmittedSurvey;
use App\Http\Requests\StoreSubmittedSurveyRequest;

class SubmittedSurveyController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\StoreSubmittedSurveyRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreSubmittedSurveyRequest $request)
	{
		$submittedSurvey = $request->validated();
		$achievedScore = 0;
		
		// evaluate score
		foreach($submittedSurvey['answers'] as $key => $value) {
			$id = $value[0]['id'];
			$value = $value[0]['value'];
			$question = SurveyQuestion::where('id', $id)->firstOrFail();
			$achievedScore = (int) $this->countScore($value, $id, $question, $achievedScore);
			$achievedScoreInPercent = round(($achievedScore * 100) / $submittedSurvey['total_score']);
		}
		
		// prepare submitted data for store into DB 
		$prepareToStore = [
			'user_id' => $submittedSurvey['user_id'],
			'survey_id' => $submittedSurvey['survey_id'],
			'author_user_id' => $submittedSurvey['author_user_id'],
			'achieved_score' => $achievedScore,
			'total_score' => $submittedSurvey['total_score'],
			'achieved_score_in_percent' => $achievedScoreInPercent
		];
		
		// change meta data of current survey and user
		$currentSurvey = Survey::where('id', $submittedSurvey['survey_id'])->firstOrFail();
		$currentUser = User::where('id', $submittedSurvey['user_id'])->firstOrFail();
		$currentSurvey->submitted++;
		$currentUser->score = $currentUser->score + $achievedScore;

		// finnaly save data
		$currentSurvey->save();
		$currentUser->save();
		SubmittedSurvey::create($prepareToStore);

		return response(['success' => true]);
	}


	/**
	 * count all types of score in one function
	 *
	 * @param String|Array $value 	 -> answer or answers
	 * @param Int $id 							 -> id of answer
	 * @param Array|Object $question -> question that own answer
	 * @param Int $achievedScore 		 -> score
	 * @return Int $achievedScore 	 -> finnaly rounded achieved score
	 */
	protected function countScore($value, $id, $question, $achievedScore) {
		// this is for checkbox type of answer
		if(is_array($value)) {
			$answers = json_decode(json_encode($question->answers), true);
			$correctAnswers = array_filter($answers, [$this, 'getCorrectAnswers']);
			$countOfCorrectAnswers = count($correctAnswers);

			foreach($value as $key => $val) {
				foreach($correctAnswers as $cKey => $cValue) {
					$countOfWrongAnswers = 0;
					if($val === $cValue['text']) {
						$achievedScore = $achievedScore + ($question['score'] / $countOfCorrectAnswers);
					} else {
						$countOfWrongAnswers++;
					}
				}
			}

			$achievedScore = $achievedScore - ($countOfWrongAnswers * ($question['score'] / $countOfCorrectAnswers));
			
		// this is for other types of answers
		} else if(is_string($value)) {
			if($question['type'] === 'radio' || $question['type'] === 'select') {
				return $value;
				$answers = json_decode(json_encode($question->answers), true);
				$correctAnswers = array_values(array_filter($answers, [$this, 'getCorrectAnswers']));
				if($value === $correctAnswers[0]['text']) {
					$achievedScore = $achievedScore + $question['score'];
				}
			} else {
				if(!empty($value)) $achievedScore = $achievedScore + $question['score'];
			}
		}
		return round($achievedScore);
	}


	/**
	 * Intern function for filter answers that are correct from DB
	 */
	protected function getCorrectAnswers($var) {
		if($var['correctAnswer'] == true) return $var;
	}

}
