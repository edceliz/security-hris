<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeDetachment extends Model
{
    protected $table = 'employee_detachments';

    protected $fillable = [
        'detachment_id',
        'employee_id',
        'remarks',
        'created_by',
        'date_changed'
    ];

    protected $hidden = [
        'created_by'
    ];

    function detachment() {
        return $this->belongsTo('App\Detachment')->withTrashed();
    }

    function employees() {
        return $this->hasMany('App\Employee', 'detachment_id');
    }

    function creator() {
        return $this->belongsTo('App\User', 'created_by', 'id')->withTrashed();
    }
}
