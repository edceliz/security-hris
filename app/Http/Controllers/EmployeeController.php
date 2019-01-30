<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Employee;
use App\Status;
use App\Detachment;
use App\EmployeePaginator;
use Illuminate\Pagination\LengthAwarePaginator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::with('currentStatus', 'currentDetachment', 'currentLicense')->orderBy('updated_at', 'DESC')->paginate(50);
        return view('employees.employees', ['employees' => $employees]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employees.employee_edit', ['edit' => false]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        $data = $request->all();
        $user_id = Auth::user()->id;
        $data['created_by'] = $user_id;
        $data['updated_by'] = $user_id;
        $employee = Employee::create(array_filter($data));
        $status = Status::create([
            'status' => 'Active',
            'employee_id' => $employee->id,
            'created_by' => $user_id,
            'date_changed' => $data['date_hired'],
            'remarks' => 'First Entry - Hired'
        ]);
        $employee->status_id = $status->id;
        $employee->save();
        return redirect("/employees/license/{$employee->id}");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return redirect('/employees');
        }
        $history = $employee->history();
        $license = $employee->license->last();
        return view('employees.employee', compact('employee', 'history', 'license'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit = Employee::find($id);
        if (!$edit) {
            return redirect('/employees');
        }
        return view('employees.employee_edit', compact('edit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, $id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return redirect('/employees');
        }
        $employee->update($request->all());
        return redirect("/employees/edit/{$id}")->with('success', true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        if ($employee) {
            $employee->deleted_by = Auth::user()->id;
            $employee->save();
            $employee->delete();
        }
        return redirect('/employees');
    }

    function search(Request $request) {
        $request->validate(['status' => 'required','filter' => 'required', 'value' => 'nullable']);
        if (in_array($request->filter, [
            'surname',
            'first_name',
            'current_address',
            'permanent_address'
        ]) && isset($request->value)) {
            $employees = Employee::where($request->filter, 'like', "%{$request->value}%");
        } elseif ($request->filter === 'detachment' && isset($request->value)) {
            $employees = Employee::whereHas('currentDetachment', function($query) use ($request) {
                $query->where('name', 'like', "%{$request->value}%");
            });
        } elseif ($request->filter === 'status' && isset($request->value)) {
            $employees = Employee::whereHas('currentStatus', function($query) use ($request) {
                $query->where('status', 'like', "%{$request->value}%");
            });
        // } elseif ($request->filter === 'all') {
        //     $employees = new Employee();
        // }
        } else {
            $employees = new Employee();
            // return redirect('/employees');
        }
        if ($request->status === 'active') {
            $employees = $employees->whereHas('currentStatus', function($query) {
                $query->whereNotIn('status', ['Resigned', 'AWOL', 'Retired', 'Suspended', 'Terminated']);
            });
        } elseif ($request->status === 'inactive') {
            $employees = $employees->whereHas('currentStatus', function($query) {
                $query->whereIn('status', ['Resigned', 'AWOL', 'Retired', 'Suspended', 'Terminated']);
            });
        }
        $employees = $employees->orderBy('updated_at', 'DESC')->paginate(50)
            ->withPath("/employees/search?status={$request->status}&filter={$request->filter}&value={$request->value}");
        return view('employees.employees', [
            'employees' => $employees, 
            'search' => [
                'filter' => $request->filter,
                'value' => $request->value
            ]
        ]);
    }
}
