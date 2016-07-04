<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\OauthController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class OauthController extends Controller
{
    public function getToken() {
		return Response::json(Authorizer::issueAccessToken());
	}
}
