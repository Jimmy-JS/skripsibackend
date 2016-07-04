<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\QuestionnaireAvailableAnswer;
use App\Models\QuestionnaireQuestion;
use Illuminate\Http\Request;
use Cache;
use Auth;

class QuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Question';
        $group = 'Questionnaire';
        $questions = QuestionnaireQuestion::where('built_in', 0)->orderBy('position', 'ASC')->get();
        $builtInQuestions = QuestionnaireQuestion::where('built_in', 1)->get();
        $isSuperAdmin = Auth::user()->is_super_admin;
        return view('backend.questionnaire.index', compact(['title', 'group', 'questions', 'builtInQuestions', 'isSuperAdmin']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (empty(Auth::user()->is_super_admin)) {
            abort(403);
        }
        $title = 'Create New Question';
        $group = 'Questionnaire';
        return view('backend.questionnaire.form', compact(['title', 'group']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (empty(Auth::user()->is_super_admin)) {
            abort(403);
        }
        $question = $request->input('question');
        $type = $request->input('type');
        $required = $request->input('required');
        if (!$required) {
            $required = 0;
        }
        $lastPosition = QuestionnaireQuestion::orderBy('position', 'DESC')->first();
        $position = $lastPosition->position + 1;
        $create = QuestionnaireQuestion::create([
            'question' => $question,
            'type' => $type,
            'position' => $position,
            'required' => $required,
            'built_in' => 0,
        ]);
        $createId = $create->id;
        if ($type == 'Checkbox' || $type == 'Radio') {
            $answers = $request->input('answer');
            foreach($answers as $answer) {
                QuestionnaireAvailableAnswer::create([
                    'questionnaire_question_id' => $createId,
                    'answer' => $answer
                ]);
            }
        }
        return redirect('questionnaire')->with('notif_success', 'Question was Added Successfully');
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
        $qQuestion = QuestionnaireQuestion::find($id);
        if (empty($qQuestion)) {
            return redirect('questionnaire')->with('notif_error', 'Can\'t Find Question with ID #'.$id);
        } else {
            $type = $qQuestion->type;
            $question = $qQuestion->question;
            $required = $qQuestion->required;

            if ($type == 'text' || $type == 'Textarea') {
                $error = 'This question type is ' . $type . ' !';
            } else {
                $answers = QuestionnaireAvailableAnswer::where('questionnaire_question_id', $id)->get();
            }
        }
        return view('backend.questionnaire.answer_modal', compact('error', 'type', 'question', 'answers', 'required'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (empty(Auth::user()->is_super_admin)) {
            abort(403);
        }
        $title = 'Edit Question';
        $group = 'Questionnaire';

        $question = QuestionnaireQuestion::find($id);
        if (empty($question)) {
            return redirect('questionnaire')->with('notif_error', 'Can\'t Find Question with ID #'.$id);
        } else {
            if ($question->type == 'Checkbox' || $question->type == 'Radio') {
                $answers = QuestionnaireAvailableAnswer::where('questionnaire_question_id', $question->id)->get();
            }
        }
        return view('backend.questionnaire.form', compact(['title', 'group', 'question', 'answers']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (empty(Auth::user()->is_super_admin)) {
            abort(403);
        }
        $question = $request->input('question');
        $type = $request->input('type');
        $required = $request->input('required');
        if (!$required) {
            $required = 0;
        }
        $qQuestion = QuestionnaireQuestion::find($id);
        if (empty($question)) {
            return redirect('questionnaire')->with('notif_error', 'Can\'t Find Question with ID #'.$id);
        }

        $update = $qQuestion->update([
            'question' => $question,
            'type' => $type,
            'required' => $required
        ]);
        if($update) {
            QuestionnaireAvailableAnswer::where('questionnaire_question_id', $id)->delete();
            if ($type == 'Checkbox' || $type == 'Radio') {
                $answers = $request->input('answer');
                foreach($answers as $answer) {
                    QuestionnaireAvailableAnswer::create([
                        'questionnaire_question_id' => $id,
                        'answer' => $answer
                    ]);
                }
            }
        }
        return redirect('questionnaire')->with('notif_success', 'Question was Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id = null)
    {
        if (empty(Auth::user()->is_super_admin)) {
            abort(403);
        }
        if(!empty($id)){
            $question = QuestionnaireQuestion::find($id);
            if(empty($question)) return redirect('questionnaire')->with('notif_error', 'Can\'t find question with ID #'.$id);
            if($question->built_in == 1) return redirect('questionnaire')->with('notif_error', 'Can\'t delete built in question!');
            
            $question = QuestionnaireQuestion::destroy($id);
            $answer = QuestionnaireAvailableAnswer::where('questionnaire_question_id', $id)->delete();
            return redirect('questionnaire')->with('notif_success', 'Delete Success');
        }else{
            return redirect('questionnaire')->with('notif_error', 'ID Can\'t be NULL');
        }
    }

    public function flushQuestionCache() {
        Cache::forget('questionnaireQuestionList'); // flush cache
        return redirect('questionnaire')->with('notif_success', 'Flush Success');
    }

    public function changePosition($type, $id)
    {
        $data = [];
        $question = QuestionnaireQuestion::find($id);
        if(empty($question)) {
            $data = [
                'status' => 'error',
                'message' => 'Can\'t find question with ID #'.$id
            ];
        }
        $position = $question->position;
        if ($type == 'down') {
            $higherPositionQuestion = QuestionnaireQuestion::where('position', '>', $position)->orderBy('position', 'ASC')->first();
            $higherPosition = $higherPositionQuestion->position;
            $higherPositionQuestion->update(['position' => $position]);
            QuestionnaireQuestion::find($id)->update(['position' => $higherPosition]);
            $data = [
                'status' => 'success',
                'message' => 'Change Position Success!'
            ];
        } else if ($type == 'up') {
            $lowerPositionQuestion = QuestionnaireQuestion::where('position', '<', $position)->orderBy('position', 'DESC')->first();
            $lowerPosition = $lowerPositionQuestion->position;
            $lowerPositionQuestion->update(['position' => $position]);
            QuestionnaireQuestion::find($id)->update(['position' => $lowerPosition]);
            $data = [
                'status' => 'success',
                'message' => 'Change Position Success!'
            ];
        } else {
            $data = [
                'status' => 'error',
                'message' => 'Error! Unknown Position Type'
            ];
        }
        return response()->json($data);
    }
}
