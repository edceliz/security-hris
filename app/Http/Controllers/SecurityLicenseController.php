<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\SecurityLicense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class SecurityLicenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return redirect('/employees');
        }
        $data = $request->validate([
            'number' => "required|unique:security_licenses,employee_id,{$id}",
            'date_issued' => 'required|date|before:date_expired',
            'date_expired' => 'required|date|after:date_issued',
            'remarks' => 'nullable'
        ]);
        $data['employee_id'] = $employee->id;
        $data['created_by'] = Auth::user()->id;
        $license = SecurityLicense::create(array_filter($data));
        $new = (bool) $employee->license_id;
        $employee->license_id = $license->id;
        $employee->updated_by = Auth::user()->id;
        $employee->save();
        // Redirects to employee job details if license is setup for the first time
        if ($new) {
            return redirect("/employees/license/{$employee->id}")->with('success', true);
        } else {
            return redirect("/employees/job/{$employee->id}");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * The ID pertains to employee's ID
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return redirect('/employees');
        }
        $license = SecurityLicense::find($employee->license_id);
        return view('employees.employee_license', ['employee' => $employee, 'license' => $license]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
