<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'position',
        'employee_id',
        'remarks',
        'created_by',
        'date_changed'
    ];

    protected $hidden = [
        'created_by'
    ];

    function employees() {
        return $this->hasMany('App\Employee', 'position_id');
    }

    function creator() {
        return $this->belongsTo('App\User', 'created_by', 'id')->withTrashed();
    }
}
