<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;

class FeedbackController extends Controller
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rating = $request->get('rating');
        $search = $request->get('search');
        $group = $title = 'Feedback';

        $perPage = 10;
        $this->generateUserIdWithFilteredData($search);
        $data = Feedback::with('user')->whereIn('user_id', $this->userIdWithFilteredData)->orderBy('rating', 'DESC');
        if(!empty($rating)) $data = $data->where('rating', $rating);
        $feedbacks = $data->paginate($perPage);
        $page = request()->get('page', 1);
        $startNumber = ($page - 1) * $perPage;

        return view('backend.feedback.index', compact(['title', 'group', 'startNumber', 'feedbacks']));
    }

    public function recent()
    {
        $title = 'Feedback';
        $group = 'Monitoring';

        $perPage = 10;
        $feedbacks = Feedback::with('user')->orderBy('created_at', 'DESC')->paginate($perPage);
        $page = request()->get('page', 1);
        $startNumber = ($page - 1) * $perPage;

        return view('backend.monitoring.feedback.index', compact(['title', 'group', 'startNumber', 'feedbacks']));
    }

    public function generateUserIdWithFilteredData($search) {
        $data = User::where('is_admin', 0);
        if(!empty($search)) $data = $data->where('first_name', 'LIKE', '%'.$search.'%')->orWhere('last_name', 'LIKE', '%'.$search.'%')->orWhere('nim', 'LIKE', '%'.$search.'%');
        $this->_setUserIdWithFilteredData($data->lists('id'));
        return 0;
    }
}
