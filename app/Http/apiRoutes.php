<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::post('oauth/access_token', 'OauthController@getToken');

Route::group(['middleware' => 'oauth'], function () { //using oAuth2 required access_token on URL (GET) or on body (POST)
	Route::post('feedback', 'FeedbackController@store');
	Route::get('profile/{username}', 'AlumniController@viewProfile');
	Route::put('profile/{username}', 'AlumniController@editProfile');
	Route::get('friends/{username}', 'AlumniController@getFriends');
	Route::get('user/{username}/workExperience', 'WorkExperienceController@index');
	Route::post('user/{username}/workExperience', 'WorkExperienceController@store');
	Route::put('user/{username}/workExperience/{id}', 'WorkExperienceController@update');
	Route::delete('user/{username}/workExperience/{id}', 'WorkExperienceController@delete');
	Route::get('questionnaire/{username}', 'QuestionnaireController@index');
	Route::post('questionnaire/{username}', 'QuestionnaireController@store');
});
Route::post('login', 'AlumniController@login');
Route::post('user', 'AlumniController@store');