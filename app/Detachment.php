<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Detachment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'address'
    ];

    protected $dates = [
        'deleted_at'
    ];

    function employeeDetachment() {
        return $this->hasMany('App\EmployeeDetachment')->with('employees');
    }

    function employees() {
        return $this->hasMany('App\Employee');
    }
}
