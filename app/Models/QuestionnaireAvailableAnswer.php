<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionnaireAvailableAnswer extends Model
{
    use SoftDeletes; 
    protected $fillable = ['questionnaire_question_id', 'answer'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
