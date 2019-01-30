<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SecurityLicense extends Model
{
    protected $fillable = [
        'employee_id',
        'number',
        'date_issued',
        'date_expired',
        'remarks',
        'created_by'
    ];

    protected $hidden = [
        'created_by'
    ];

    function creator() {
        return $this->belongsTo('App\User', 'created_by', 'id')->withTrashed();
    }
}