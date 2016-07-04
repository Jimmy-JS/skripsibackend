<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;

class FeedbackController extends ApiController
{
    public function store(Request $request) {
    	$username = $request->input('username');
    	$user = User::where('nim', $username)->orWhere('email', $username)->first();

    	if($user) {
    		$userId = $user->id;
    	} else {
    		return $this->respondNotFound('User not found on our server!');
    	}

    	$data['rating'] = $request->input('rating');
    	$data['feedback'] = $request->input('feedback');
    	$data['user_id'] = $userId;
    	if(!empty($data['rating']) && !empty($data['feedback'])) {
    		try {
    			$response = Feedback::create($data);
    			return $this->respondCreated('Feedback Sent! Thank you!', $response);
	        } catch(\Exception $e) {
	            return $this->setStatusCode(404)->makeResponse(null, [$e]);
	        }
    	} else {
    		return $this->respondValidationError('Rating & Feedback Can\'t be Blank!');
    	}
    }
}
