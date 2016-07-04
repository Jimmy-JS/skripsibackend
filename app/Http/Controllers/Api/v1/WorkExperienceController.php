<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\User;
use App\Models\WorkingExperience;
use Illuminate\Http\Request;
use Cache;

class WorkExperienceController extends ApiController
{
    public function index($username) {
        $user = User::where('nim', $username)->orWhere('email', $username)->first();

        if($user) {
        	$userId = $user->id;
            $workExperiences = Cache::rememberForever('workExperiencesListFromUserId'.$userId, function() use($userId) {
            // cache forever until some work experience has been updated / stored / deleted
                return WorkingExperience::whereUserId($userId)->orderBy('start_date', 'DESC')->get();
            });
    		return $this->makeResponse(null, $workExperiences);
        } else {
            return $this->respondNotFound('User not found on our server!');
        }
    }

    public function store($username, Request $request) {
        $user = User::where('nim', $username)->orWhere('email', $username)->first();

        if($user) {
        	$userId = $user->id;

			$dataInsert['user_id'] = $userId;
			$dataInsert['position'] = $request->input('position');
			$dataInsert['company'] = $request->input('company');
			$dataInsert['start_date'] = $request->input('startDate');
			$dataInsert['end_date'] = $request->input('endDate');
			$dataInsert['location'] = $request->input('location');
			$dataInsert['country'] = $request->input('country');

			$response = WorkingExperience::create($dataInsert);
            Cache::forget('workExperiencesListFromUserId' . $userId); // flush cache
    		return $this->respondCreated('Work Experience has been Added Successfully', $response);
        } else {
            return $this->respondNotFound('User not found on our server!');
        }
    }

    public function update($username, $id, Request $request) {
        $user = User::where('nim', $username)->orWhere('email', $username)->first();

        if($user) {
        	$userId = $user->id;
    		$workExperience = WorkingExperience::find($id);
    		if($workExperience) {
	    		if ($workExperience->user_id == $userId) {
	    			$dataInsert['position'] = $request->input('position');
	    			$dataInsert['company'] = $request->input('company');
	    			$dataInsert['start_date'] = $request->input('startDate');
	    			$dataInsert['end_date'] = $request->input('endDate');
	    			$dataInsert['location'] = $request->input('location');
	    			$dataInsert['country'] = $request->input('country');

	    			$workExperience->update($dataInsert);
                    Cache::forget('workExperiencesListFromUserId' . $userId); // flush cache
		    		return $this->makeResponse('Data has been Updated Successfully');
	    		} else {
	            	return $this->respondUnauthorized('You\'re not allowed to update working experience!');
	        	}
	        } else {
            	return $this->respondNotFound('Selected Working Experience not found on our server!');
	        }
        } else {
            return $this->respondNotFound('User not found on our server!');
        }
    }

    public function delete($username, $id) {
        $user = User::where('nim', $username)->orWhere('email', $username)->first();

        if($user) {
        	$userId = $user->id;
    		$workExperience = WorkingExperience::find($id);
    		if($workExperience) {
	    		if ($workExperience->user_id == $userId) {
	    			$workExperience->delete();
                    Cache::forget('workExperiencesListFromUserId' . $userId); // flush cache
		    		return $this->makeResponse('Data has been Deleted Successfully');
	    		} else {
	            	return $this->respondUnauthorized('You\'re not allowed to delete working experience!');
	        	}
	        } else {
            	return $this->respondNotFound('Selected Working Experience not found on our server!');
	        }
        } else {
            return $this->respondNotFound('User not found on our server!');
        }
    }
}
