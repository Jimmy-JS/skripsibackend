<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionnaireResponse extends Model
{
    use SoftDeletes; 
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = ['user_id', 'questionnaire_question_id', 'response'];

    public function user() {
    	return $this->belongsTo('App\Models\User');
    }

    public function answer() {
    	return $this->belongsTo('App\Models\QuestionnaireAvailableAnswer', 'response', 'id');
    }
}