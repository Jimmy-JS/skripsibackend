<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\QuestionnaireQuestion;
use App\Models\QuestionnaireResponse;
use App\Models\User;
use App\Models\WorkingExperience;
use Illuminate\Http\Request;
use DB;

class AlumniController extends Controller
{
    public static $studyProgram = ['Teknik Informatika','Akuntansi','Kedokteran'];
    public function recent()
    {
        $perPage = 10;
        $alumni = User::where('is_admin', 0)->orderBy('created_at', 'DESC')->paginate($perPage);
        $page = request()->get('page', 1);
        $startNumber = ($page - 1) * $perPage;

        return view('backend.monitoring.alumni.index', compact(['startNumber', 'alumni']));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $studyProgram = $request->get('studyProgram');
        $class = $request->get('class');
        $search = $request->get('search');

        $classYears = User::select(DB::raw('DISTINCT(class) as class'))->where('is_admin', 0)->orderBy('class')->get();

        $perPage = 12;
        $data = User::where('is_admin', 0);
        if(!empty($studyProgram)) $data = $data->where('study_program_id', 1);
        if(!empty($class)) $data = $data->where('class', $class);
        if(!empty($search)) $data = $data->where(function ($q) use ($search) {
            $q->where('first_name', 'LIKE', '%'.$search.'%')
                ->orWhere('last_name', 'LIKE', '%'.$search.'%')
                ->orWhere('nim', 'LIKE', '%'.$search.'%');
        });
        $alumni = $data->paginate($perPage);
        $studyProgram = self::$studyProgram;

        return view('backend.alumni.index', compact(['classYears', 'startNumber', 'alumni', 'studyProgram']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $alumni = User::find($id);
        if ($alumni->is_admin || $alumni->is_super_admin) {
            return redirect()->back()->with('notif_error', 'Alumni Not Found');
        }

        if (empty($alumni)) {
            return redirect()->back()->with('notif_error', 'Alumni Not Found');
        }

        $qResponse = QuestionnaireResponse::where('user_id', $id)->get();
        if (count($qResponse) > 0) {
            $isFilled = true;
            $responses = QuestionnaireQuestion::with([
                'response' => function($query) use($id) {
                    $query->where('user_id', $id);
                }, 'answers'
            ])->get();
        } else {
            $isFilled = false;
        }

        $studyProgram = self::$studyProgram;

        $workingExperiences = WorkingExperience::where('user_id', $id)->orderBy('start_date', 'ASC')->get();
        return view('backend.alumni.show', compact('alumni', 'studyProgram', 'isFilled', 'responses', 'workingExperiences'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
