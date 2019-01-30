<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'surname',
        'first_name',
        'middle_initial',
        'blood_type',
        'current_address',
        'permanent_address',
        'contact_number',
        'birthday',
        'civil_status',
        'dependents_no',
        'sss',
        'tin',
        'philhealth',
        'pagibig',
        'health_insurance',
        'license_id',
        'status_id',
        'detachment_id',
        'emergency_contact',
        'emergency_number',
        'created_by',
        'updated_by',
        'deleted_by',
        'date_hired'
    ];

    protected $hidden = [
        'license_id', 'status_id', 'detachment_id', 'created_by', 'updated_by', 'deleted_by'
    ];

    protected $dates = [
        'deleted_at',
        'date_hired'
    ];

    /**
     * All status
     */
    function status() {
        return $this->hasMany('App\Status');
    }

    /**
     * All licenses
     */
    function license() {
        return $this->hasMany('App\SecurityLicense');
    }

    /**
     * All detachments
     */
    function detachment() {
        return $this->hasMany('App\EmployeeDetachment')->with(['detachment', 'creator']);
    }

    function positions() {
        return $this->hasMany('App\Position');
    }

    /**
     * Collection of all changes related to the employee's job
     * 
     * This is used to display the history of the employee.
     */
    function history() {
        $license = collect($this->license);
        $status = collect($this->status);
        $detachment = collect($this->detachment);
        $position = collect($this->positions);
        return $license->merge($status)->merge($detachment)->merge($position)->sortByDesc('created_at');
    }

    function currentStatus() {
        return $this->hasOne('App\Status', 'id', 'status_id');
    }

    function currentLicense() {
        return $this->hasOne('App\SecurityLicense', 'id', 'license_id');
    }

    function currentDetachment() {
        return $this->belongsTo('App\Detachment', 'detachment_id');
    }

    function currentPosition() {
        return $this->hasOne('App\Position', 'id', 'position_id');
    }
}
