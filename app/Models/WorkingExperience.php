<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class WorkingExperience extends Model
{
    protected $fillable = ['user_id', 'position', 'company', 'location', 'country', 'start_date', 'end_date'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $dates = ['created_at', 'deleted_at', 'updated_at'];

    protected $appends = ['formated_start_date', 'formated_end_date'];

    public function getFormatedStartDateAttribute() {
    	$date = Carbon::createFromFormat('Y-m-d', $this->attributes['start_date']);
    	return $date->format('F Y');
    }

    public function getFormatedEndDateAttribute() {
    	$date = Carbon::createFromFormat('Y-m-d', $this->attributes['end_date']);
    	return $date->format('F Y');
    }
}
