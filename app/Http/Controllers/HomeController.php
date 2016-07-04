<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Feedback;
use App\Models\QuestionnaireResponse;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date = new Carbon;
        $lastWeekDate = $date->subWeek();
        $recentAlumniCount = [
            'recentSignUp' => User::where('is_admin', 0)->where('created_at', '>', $lastWeekDate->toDateTimeString())->count()
        ];
        $recentFeedbackCount = [
            'recentFeedback' => Feedback::where('created_at', '>', $lastWeekDate->toDateTimeString())->count()
        ];
        $recentResponseCount = [
            'recentResponse' => QuestionnaireResponse::groupBy('user_id')->where('created_at', '>', $lastWeekDate->toDateTimeString())->get()->count()
        ];
        $statistic = [
            'statistic' => array_merge($recentAlumniCount, $recentFeedbackCount, $recentResponseCount)
        ];

        $recentAlumni = ['recentAlumni' => User::where('is_admin', 0)->orderBy('created_at', 'DESC')->take(5)->get()->toArray()];
        $recentFeedback = ['recentFeedback' => Feedback::with('user')->orderBy('created_at', 'DESC')->take(2)->get()->toArray()];
        $data = array_merge($statistic, $recentAlumni, $recentFeedback);
        return view('backend.dashboard', compact('data'));
    }

    public function modalDelete($route, $id = null)
    {
        try{
            //$testroute = route($route.'.destroy', $id);
            $route = $route.'.destroy';
            $id = $id;
            $error = null;
        }catch(\Exception $e){
            $route = null;
            $error = 'Error Occured';
        }
        return View('layouts.modal_confirmation', compact('error', 'route', 'id'));
    }
}
