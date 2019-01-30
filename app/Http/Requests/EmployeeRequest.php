<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'surname' => 'required',
            'first_name' => 'required',
            'middle_initial' => 'required',
            'blood_type' => 'nullable',
            'current_address' => 'required',
            'permanent_address' => 'required',
            'contact_number' => "required",
            'birthday' => 'required',
            'civil_status' => 'required',
            'dependents_no' => 'required',
            'sss' => "required|unique:employees,sss,{$this->route('id')}",
            'tin' => "required|unique:employees,tin,{$this->route('id')}",
            'philhealth' => "required|unique:employees,philhealth,{$this->route('id')}",
            'pagibig' => "required|unique:employees,pagibig,{$this->route('id')}",
            'health_insurance' => "nullable|unique:employees,health_insurance,{$this->route('id')}",
            'emergency_contact' => 'nullable',
            'emergency_number' => 'nullable',
            'date_hired' => 'nullable'
        ];
    }
}