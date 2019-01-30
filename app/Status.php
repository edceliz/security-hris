<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';

    protected $fillable = [
        'status',
        'employee_id',
        'remarks',
        'created_by',
        'date_changed'
    ];

    protected $hidden = [
        'created_by'
    ];

    function employees() {
        return $this->hasMany('App\Employee', 'status_id');
    }

    function creator() {
        return $this->belongsTo('App\User', 'created_by', 'id')->withTrashed();
    }
}
