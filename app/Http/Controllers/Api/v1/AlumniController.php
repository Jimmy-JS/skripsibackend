<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests;
use App\Models\User;
use Illuminate\Http\Request;
use Hash;
use Cache;

class AlumniController extends ApiController
{
    public function login(Request $request) {
        $username = $request->input('username');
        $password = $request->input('password');

        if(!empty($username) && !empty($password)) {
            $user = User::select('password')->where('nim', $username)->orWhere('email', $username)->first();

            if ($user) {
                if (Hash::check($password, $user->password)) {
                    return $this->makeResponse('You have Successfully Logged In');
                } else {
                    return $this->respondValidationError('Your NIM / Email and Password is not match!');
                }
            } else {
                return $this->respondNotFound("Your NIM / Email Not Found on our Server");
            }
        } else {
            return $this->respondValidationError('Username or Password can\'t be blank');
        }
    }

    public function store(Request $request) {
        $data['nim'] = $request->input('nim');
        $data['email'] = $request->input('email');
        $data['study_program_id'] = $request->input('studyProgramId');
        $data['password'] = bcrypt($request->input('password'));
        $data['first_name'] = $request->input('firstName');
        $data['last_name'] = $request->input('lastName');
        $data['gender'] = $request->input('gender');
        $data['id_number'] = $request->input('idNumber');
        $data['class'] = $request->input('class');
        $data['phone'] = $request->input('phone');
        $data['birth_date'] = $request->input('birthDate');
        $data['birth_place'] = $request->input('birthPlace');
        $data['religion'] = $request->input('religion');
        $data['address'] = $request->input('address');
        $data['is_admin'] = 0;

        try {
            $user = User::create($data);
        } catch(\Exception $e) {
            return $this->setStatusCode(404)->makeResponse(null, [$e]);
        }

        if ($user) {
            return $this->makeResponse('Successfully Registered!');
        }
    }

    public function viewProfile($username) {
        $user = User::where('nim', $username)->orWhere('email', $username)->first();

        if($user) {
            return $this->makeResponse(null, $user);
        } else {
            return $this->respondNotFound('User not found on our server!');
        }
    }

    public function editProfile($username, Request $request) {
        $dataUpdate['first_name'] = $request->input('firstName');
        $dataUpdate['last_name'] = $request->input('lastName');
        $dataUpdate['email'] = $request->input('email');
        $dataUpdate['phone'] = $request->input('phone');
        $dataUpdate['religion'] = $request->input('religion');
        $dataUpdate['address'] = $request->input('address');

        $user = User::where('nim', $username)->orWhere('email', $username)->first();

        if($user) {
            $isEmailExist = User::where('email', $dataUpdate['email'])->where('id', '!=', $user->id)->first();
            if(!$isEmailExist) {
                $user->update($dataUpdate);
                return $this->makeResponse('Your Profile has been Updated Successfully');
            } else {
                return $this->respondValidationError('Email is already used by another user. Please choose other email!');
            }
        } else {
            return $this->respondNotFound('User not found on our server!');
        }
    }

    public function getFriends($username) {
        $user = User::where('nim', $username)
                ->orWhere('email', $username)
                ->first();

        if($user) {
            $thisNim = $user->nim;
            $studyProgramId = $user->study_program_id;
            $class = $user->class;
            $friends = Cache::remember('getFriendsClass'.$class."StudyProgramId".$studyProgramId."Nim".$thisNim, 60, 
                function() use($studyProgramId, $class, $thisNim) { // cache for 60 mins add variable class, studyprogramid, nim   
                    return User::where('study_program_id', $studyProgramId)
                            ->where('class', $class)
                            ->where('nim', '!=', $thisNim)
                            ->where('is_admin', 0)
                            ->get();
                });

            return $this->makeResponse(null, $friends);
        } else {
            return $this->respondNotFound('User not found on our server!');
        }
    }
}