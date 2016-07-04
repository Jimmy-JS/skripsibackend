<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\AccountRequest;
use App\Models\User;
use Auth;

class AccountController extends Controller
{
    public function create($type) {
        if (empty(Auth::user()->is_super_admin)) {
            abort(403);
        }
    	if ($type == 'superAdmin') {
        	$title = 'Create New Super Admin Account';
    	} else if ($type == 'admin') {
        	$title = 'Create New Staff Account';
    	} else {
    		abort(404);
    	}
        $group = 'Account Management';
        return view('backend.account-management.form', compact(['title', 'group', 'type']));
    }

    public function store(AccountRequest $request) {
        if (empty(Auth::user()->is_super_admin)) {
            abort(403);
        }
        $data = $request->all();

        try {
            User::create([
                'nim' => time(),
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'first_name' => $data['firstName'],
                'last_name' => $data['lastName'],
                'is_admin' => $data['isAdmin'],
                'is_super_admin' => $data['isSuperAdmin']
            ]);
        } catch (\Exception $e) {
            redirect()->back()->with('notif_error', $e->getMessage());
        }

        return redirect()->back()->with('notif_success', 'Account has been Created Successfully!');
    }
}
