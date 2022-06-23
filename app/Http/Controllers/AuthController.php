<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\SurveyResource;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
	/**
	 * REGISTER USER method
	 */
  public function register(Request $request) {
		$data = $request->validate([
			'fullname' => 'required|string',
			'email' => 'required|email|string|unique:users,email',
			'password' => [
				'required',
				'confirmed',
				// Password::min(8)->mixedCase()->numbers()->symbols()
				Password::min(4)
			]
		]);

		$user = User::create([
      'name' => $data['fullname'],
      'email' => $data['email'],
      'password' => bcrypt($data['password'])
    ]);
    $token = $user->createToken('main')->plainTextToken;

    return response([
      'user' => $user,
      'token' => $token
    ]);
	}

	
	/**
	 * LOGIN USER method
	 */
	public function login(Request $request) {
    $credentials = $request->validate([
      'email' => 'required|email|string|exists:users,email',
      'password' => 'required',
      'remember' => 'boolean'
    ]);
    $remember = $credentials['remember'] ?? false;
    unset($credentials['remember']);

    if(!Auth::attempt($credentials, $remember)) {
      return response([
        'error' => 'The provided credentials are not correct'
      ], 422);
    }

    $user = Auth::user();
    $token = $user->createToken('main')->plainTextToken;

    return response([
      'user' => $user,
      'token' => $token
    ]);
  }


	/**
	 * LOGOUT USER method
	 */
	public function logout(Request $request) {
    $user = Auth::user();
    $user->currentAccessToken()->delete();
    return response(['success' => true]);
  }


  public function getDashboardNumbers(Request $request) {
    $user = Auth::user();
    $surveys = Survey::where('user_id', $user['id'])->get();
    $numOfSubmitted = 0;
    foreach ($surveys as $key => $value) {
      $numOfSubmitted = $numOfSubmitted + $value['submitted'];
    }
    $numOfSurveys = count($surveys);
    return response([
      'followers' => $user['followers'],
      'score' => $user['score'],
      'numOfSurveys' => $numOfSurveys,
      'numOfSubmitted' => $numOfSubmitted
    ]);
  }

  public function getDashboardSurveys(Request $request) {
    $user = Auth::user();
    $latestSurvey = Survey::where('user_id', $user['id'])->latest()->first();
    $latestAnsweredSurvey = $latestSurvey; // docasne
    // posledne odpovedany survey podla answer dateu
    $surveyWithBiggestScore = $latestSurvey; // docasne
    // zobrat survey s najvyssim score co user spravil
    return response([
      'latestSurvey' => $latestSurvey,
      'latestAnswer' => $latestAnsweredSurvey,
      'biggestScore' => $surveyWithBiggestScore
    ]);
  }
}
