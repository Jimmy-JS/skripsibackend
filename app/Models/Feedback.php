<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    use SoftDeletes; 
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = ['user_id', 'feedback', 'rating'];

    public function user() {
    	return $this->belongsTo('App\User');
    }

    protected $appends = [
        'formatted_created_at'
    ];

    public function getFormattedCreatedAtAttribute() {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at']);
        return $date->format('d F\'y');
    }
}
