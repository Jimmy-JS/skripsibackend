<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Feedback;
use App\Models\QuestionnaireResponse;
use App\Models\User;
use App\Models\WorkingExperience;
use DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    private $userIdWithFilteredData;

    public function getUserIdWithFilteredData()
    {
        return $this->userIdWithFilteredData;
    }

    private function _setUserIdWithFilteredData($userIdWithFilteredData)
    {
        $this->userIdWithFilteredData = $userIdWithFilteredData;

        return $this;
    }

    public function index(Request $request) {
    	$studyProgram = $request->get('studyProgram');
    	$class = $request->get('class');

    	$classYears = User::select(DB::raw('DISTINCT(class) as class'))->where('is_admin', 0)->orderBy('class')->get();

    	$this->generateUserIdWithFilteredData($studyProgram, $class);

    	// SELECT COUNT(DISTINCT(user_id)) as filled_questionnaire FROM questionnaire_responses WHERE user_id IN [$this->getUserIdWithFilteredData()]
    	$filledQuestionnaire = count(
    		QuestionnaireResponse::select([DB::raw('DISTINCT(user_id) AS filled_questionnaire')])
				    				->whereIn('user_id', $this->getUserIdWithFilteredData())
				    				->get()
    	);
    	$totalAlumni = count($this->getUserIdWithFilteredData());
    	$unfilledQuestionnaire = $totalAlumni - $filledQuestionnaire;

    	// SELECT (SUM(rating) / COUNT(*)) as average_rating FROM feedbacks WHERE user_id IN [$this->getUserIdWithFilteredData()]
    	$averageRating = round(
    		Feedback::select(DB::raw('(SUM(rating) / COUNT(*)) AS average_rating'))
    					->whereIn('user_id', $this->getUserIdWithFilteredData())
    					->first()
    					->average_rating
    	, 1);

    	// SELECT country, COUNT(country) AS count FROM working_experiences WHERE user_id IN [$this->getUserIdWithFilteredData()] GROUP BY country
    	$countries = WorkingExperience::select(['country', DB::raw('COUNT(country) AS count')])
    									->whereIn('user_id', $this->getUserIdWithFilteredData())
    									->groupBy('country')->get();
    	$max = $countries->max("count");

    	// SELECT response, COUNT(response) AS total FROM questionnaire_responses WHERE questionnaire_question_id = [$buildInQuestionId] WHERE user_id IN [$this->getUserIdWithFilteredData()] GROUP BY response
    	$buildInQuestionId = [997, 998];
    	$firstBuildInQuestionResponses = $this->generateTotalResponses($buildInQuestionId[0]);
    	$secondBuildInQuestionResponses = $this->generateTotalResponses($buildInQuestionId[1]);

    	return view('backend.reporting.index', compact('classYears', 'filledQuestionnaire', 'unfilledQuestionnaire', 'averageRating', 'countries', 'max', 'firstBuildInQuestionResponses', 'secondBuildInQuestionResponses'));
    }

    public function generateUserIdWithFilteredData($studyProgram, $class) {
    	$data = User::where('is_admin', 0);
    	if(!empty($studyProgram)) $data = $data->where('study_program_id', $studyProgram);
    	if(!empty($class)) $data = $data->where('class', $class);
    	$this->_setUserIdWithFilteredData($data->lists('id'));
        return 0;
    }

    function generateTotalResponses($buildInQuestionId) {
    	return QuestionnaireResponse::with(['answer' => function($q) { return $q->select(['id', 'answer']); }])
    								->select(['response', DB::raw('COUNT(response) AS total')])
    								->where('questionnaire_question_id', $buildInQuestionId)
    								->whereIn('user_id', $this->getUserIdWithFilteredData())
    								->groupBy('response')
    								->get();
    }
}
