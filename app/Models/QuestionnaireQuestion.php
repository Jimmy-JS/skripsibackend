<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionnaireQuestion extends Model
{
    use SoftDeletes; 
    protected $fillable = ['question', 'type', 'position', 'required', 'built_in'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    public function answers() {
    	return $this->hasMany('App\Models\QuestionnaireAvailableAnswer');
    }

    public function response() {
    	return $this->hasOne('App\Models\QuestionnaireResponse');
    }
}
