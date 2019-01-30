<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Employee;
use App\Position;

class PositionController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return redirect('/employees');
        }
        $data = $request->validate([
            'position' => 'required',
            'remarks' => 'nullable',
            'date_changed' => 'required|date'
        ]);
        $data['created_by'] = Auth::user()->id;
        $data['employee_id'] = $id;
        $position = Position::create(array_filter($data));
        $employee->position_id = $position->id;
        $employee->updated_by = Auth::user()->id;
        $employee->save();
        return redirect("employees/job/{$id}")->with('status_success', true);
    }
}
