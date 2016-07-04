<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nim', 'email', 'study_program_id', 'password', 'first_name', 'last_name', 'gender', 'id_number', 'class', 'phone', 'birth_date', 'birth_place', 'religion', 'address', 'is_admin', 'is_super_admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at', 'deleted_at', 'is_admin', 'is_super_admin', 'id_number'
    ];

    protected $dates = ['created_at', 'updated_at'];

    protected $appends = [
        'human_created_at'
    ];

    public function getHumanCreatedAtAttribute() {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at']);
        return $date->diffForHumans();
    }
}
