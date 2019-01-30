<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Detachment;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $detachments = Detachment::all();
        return view('reports.builder', compact('detachments'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $type)
    {
        $data = array_filter($request->all());
        $relationalFields = [
            'status',
            'detachment',
            'position'
        ];
        $dateFields = [
            'date_issued',
            'date_expired',
            'date_hired'
        ];

        $employees = Employee::with('currentDetachment', 'currentStatus');

        foreach ($relationalFields as $field) {
            if (!isset($data[$field . '_value']) || !isset($data[$field . '_filter'])) {
                continue;
            }
            switch ($field) {
                case 'status':
                    $employees->whereHas('currentStatus', function($query) use ($data, $field) {
                        $query->where(
                            'status', 
                            $data[$field . '_filter'], 
                            $data[$field . '_filter'] === 'like' ? "%{$data[$field . '_value']}%" : $data[$field . '_value']
                        );
                    });
                    break;
                case 'detachment':
                    $employees->whereHas('currentDetachment', function($query) use ($data, $field) {
                        $query->where(
                            'name',
                            $data[$field . '_filter'], 
                            $data[$field . '_filter'] === 'like' ? "%{$data[$field . '_value']}%" : $data[$field . '_value']
                        );
                    });
                    break;
                case 'position':
                    $employees->whereHas('currentPosition', function($query) use ($data, $field) {
                        $query->where(
                            'position',
                            $data[$field . '_filter'], 
                            $data[$field . '_filter'] === 'like' ? "%{$data[$field . '_value']}%" : $data[$field . '_value']
                        );
                    });
                    break;
            }
        }

        foreach ($dateFields as $field) {
            if ((!isset($data[$field . '_value_1']) || !isset($data[$field . '_value_2'])) || !isset($data[$field . '_filter'])) {
                continue;
            }
            switch ($field) {
                case 'date_issued':
                    $employees->whereHas('currentLicense', function($query) use ($data, $field) {
                        $query->whereBetween(
                            'date_issued', 
                            [$data[$field . '_value_1'], 
                            $data[$field . '_value_2']]
                        );
                    });
                    break;
                case 'date_expired':
                    $employees->whereHas('currentLicense', function($query) use ($data, $field) {
                        $query->whereBetween(
                            'date_expired', 
                            [$data[$field . '_value_1'], 
                            $data[$field . '_value_2']]
                        );
                    });
                    break;
                case 'date_hired':
                    $employees->whereBetween('date_hired', [
                        $data[$field . '_value_1'], 
                        $data[$field . '_value_2']
                    ]);
                    break;
            }
        }
        
        $query = $request->query();
        if (isset($query['page'])) {
            unset($query['page']);
        }
        $query = http_build_query($request->query());

        // Print was merged with this action to prevent repetition.
        // Improvement: Refactor, separate query builder so that print and view will use the function.
        if ($type === 'print') {
            $csvExporter = new \Laracsv\Export();
            $csvExporter->build($employees->get(), [
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
                'emergency_contact',
                'emergency_number',
                'currentStatus.status' => 'status',
                'currentLicense.number' => 'license_number',
                'currentLicense.date_expired' => 'license_expiration',
                'currentDetachment.name' => 'detachment',
                'currentPosition.position' => 'position'
            ])->download();
            die();
        }
        
        $employees = $employees
            ->paginate(50)
            ->withPath('/report/generate?' . $query);
        $data = (object) $data;
        $detachments = Detachment::all();
        return view('reports.report', compact('employees', 'data', 'detachments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
