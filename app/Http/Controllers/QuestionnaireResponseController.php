<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\QuestionnaireQuestion;
use App\Models\QuestionnaireResponse;
use App\Models\User;
use DB;
use Illuminate\Http\Request;

class QuestionnaireResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Recently Received Questionnaire Responses';
        $group = 'Monitoring';

        $respondents = QuestionnaireResponse::with('user')->select([DB::raw('DISTINCT(user_id)'), 'created_at'])->orderBy('created_at', 'DESC')->get();
        return view('backend.monitoring.questionnaire.index', compact(['title', 'group', 'respondents']));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $error = null;
        $user = User::find($id);
        if (empty($user))
            $error = 'User with ID #' . $id . ' not Found!';

        $isFilled = QuestionnaireResponse::where('user_id', $id)->first();
        if(!empty($isFilled)) {
            $questions = QuestionnaireQuestion::with([
                'response' => function($query) use($id) {
                    $query->where('user_id', $id);
                }, 'answers'
            ])->get();
        } else {
            $error = 'User #' . $id . ' is not filled questionnaire yet';
        }
        // dd($responses->toArray());

        return view('backend.monitoring.questionnaire.response_modal', compact('error', 'user', 'questions'));
    }
}
