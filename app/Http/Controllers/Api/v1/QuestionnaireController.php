<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\QuestionnaireQuestion;
use App\Models\QuestionnaireResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Cache;

class QuestionnaireController extends ApiController
{
    public function index($username) {
        $user = User::where('nim', $username)->orWhere('email', $username)->first();

        if($user) {
        	$userId = $user->id;

	        $qResponse = QuestionnaireResponse::where('user_id', $userId)->get();
	        if (count($qResponse) > 0) {
	            $isFilled = true;
	        } else { // Alumni not fill the questionnaire yet
	            $isFilled = false;
	            $questions = Cache::rememberForever('questionnaireQuestionList', function() {
				            // cache forever until some questions has been updated / stored / deleted
				                $nonBuiltInQuestions = QuestionnaireQuestion::with('answers')->where('built_in', 0)->orderBy('position', 'ASC')->get();
						        $builtInQuestions = QuestionnaireQuestion::with('answers')->where('built_in', 1)->get();

						        return $nonBuiltInQuestions->merge($builtInQuestions);
				            });
	        }

	        $data = [
	        	'isFilled' => (int)$isFilled
	        ];

        	if(isset($questions)) $data['data'] = $questions;

        	return $this->makeResponse(null, $data);
        } else {
            return $this->respondNotFound('User not found on our server!');
        }
    }

    public function store($username, Request $request) {
        $user = User::where('nim', $username)->orWhere('email', $username)->first();

        if($user) {
        	$userId = $user->id;

	        $qResponse = QuestionnaireResponse::where('user_id', $userId)->get();
	        if (count($qResponse) > 0) {
	            return $this->respondValidationError('You\'re already filled the questionnaire!');
	        } else { // Alumni not fill the questionnaire yet
	        	$questionsId = $request->input('questionsId');
	        	$responses = $request->input('responses');

	    		$count = 0;
	        	foreach($questionsId as $questionId) {
	        		$dataInsert = [
	        			'user_id' => $userId,
	        			'questionnaire_question_id' => $questionId,
	        			'response' => $responses[$count]
	        		];
		        	$response[$count] = QuestionnaireResponse::create($dataInsert);
		        	$count++;
	        	}
	        }
        	return $this->respondCreated('Questionnaire has been Submitted Successfully!', $response);
        } else {
            return $this->respondNotFound('User not found on our server!');
        }
    }
}
