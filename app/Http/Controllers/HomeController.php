<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Employee;
use App\Detachment;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $disqualifier = [
            'AWOL', 'Resigned', 'Retired', 'Terminated', 'Suspended'
        ];

        $branches = Detachment::withCount(['employees' => function($query) use ($disqualifier) {
            $query->whereHas('currentStatus', function($query2) use ($disqualifier) {
                $query2->whereNotIn('status', $disqualifier);
            });
        }])->orderBy('employees_count', 'desc')->limit(11)->get();

        $employees = Employee::whereHas('currentStatus', function($query) use ($disqualifier) {
            $query->whereNotIn('status', $disqualifier);
        })->count();

        $expiringLicenses = Employee::with('currentLicense', 'currentStatus')
            ->whereHas('currentLicense', function($query) {
                $query->whereBetween('date_expired', [date('Y-m-d'), date('Y-m-d', strtotime("+60 days"))]);
            })->whereHas('currentStatus', function($query) use ($disqualifier) {
                $query->whereNotIn('status', $disqualifier);
            })->limit(6)->get();

        $expiredLicenses = Employee::with('currentLicense', 'currentStatus')
            ->whereHas('currentLicense', function($query) {
                $query->whereDate('date_expired', '<', date('Y-m-d'));
            })->whereHas('currentStatus', function($query) use ($disqualifier) {
                $query->whereNotIn('status', $disqualifier);
            })->limit(6)->get();

        $incompleteInformation = Employee::whereHas('currentStatus', function($query) use ($disqualifier) {
                $query->whereNotIn('status', $disqualifier);
            })
            ->whereNull('blood_type')
            ->orWhereNull('emergency_contact')
            ->orWhereNull('emergency_number')
            ->limit(4)->get();
        return view('home.home', compact('employees', 'branches', 'expiringLicenses', 'expiredLicenses', 'incompleteInformation'));
    }

    public function show($type, $id) {
        if (!in_array($id, [
            'expiring',
            'expired',
            'incomplete',
            'detachments'
        ]) || !in_array($type, ['view', 'print'])) {
            return redirect('/');
        }

        $disqualifier = [
            'AWOL', 'Resigned', 'Retired', 'Terminated', 'Suspended'
        ];

        switch ($id) {
            case 'expiring':
                $title = 'Expiring Licenses';
                $list = Employee::with('currentLicense', 'currentStatus')->whereHas('currentLicense', function($query) {
                    $query->whereBetween('date_expired', [date('Y-m-d'), date('Y-m-d', strtotime("+60 days"))]);
                })->whereHas('currentStatus', function($query) use ($disqualifier) {
                    $query->whereNotIn('status', $disqualifier);
                });
                break;
            case 'expired':
                $title = 'Expired Licenses';
                $list = Employee::with('currentLicense', 'currentStatus')->whereHas('currentLicense', function($query) {
                    $query->whereDate('date_expired', '<', date('Y-m-d'));
                })->whereHas('currentStatus', function($query) use ($disqualifier) {
                    $query->whereNotIn('status', $disqualifier);
                });
                break;
            case 'incomplete':
                $list = Employee::whereHas('currentStatus', function($query) use ($disqualifier) {
                        $query->whereNotIn('status', $disqualifier);
                    })
                    ->whereNull('blood_type')
                    ->orWhereNull('emergency_contact')
                    ->orWhereNull('emergency_number');
                $title = 'Incomplete Requirements';
                break;
            case 'detachments':
                $title = 'Detachments';
                $list = DB::table('employees')
                    ->select('detachments.name', 'detachments.address', DB::raw('count(*) as total'))
                    ->join('employee_detachments', 'employee_detachments.id', 'employees.detachment_id')
                    ->join('detachments', 'detachments.id', 'employee_detachments.detachment_id')
                    ->groupBy('employee_detachments.detachment_id')
                    ->orderBy('total', 'DESC');
                break;
        }

        if ($type === 'print') {
            $csvExporter = new \Laracsv\Export();
            switch ($id) {
                case 'expiring':
                case 'expired':
                    $fields = [
                        'first_name',
                        'surname',
                        'contact_number',
                        'current_address',
                        'permanent_address',
                        'currentStatus.status' => 'status',
                        'currentLicense.number' => 'license_number',
                        'currentLicense.date_issued' => 'license_date_issued',
                        'currentLicense.date_expired' => 'license_expiration_date',
                        'currentDetachment.name' => 'detachment',
                        'currentPosition.position' => 'position'
                    ];
                    break;
                case 'incomplete':
                    $fields = [
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
                    ];
                    break;
                case 'detachments':
                    $fields = [
                        'name',
                        'address',
                        'total_employees'
                    ];

                    header('Content-Disposition: attachment; filename="detachments.csv"');
                    header("Cache-control: private");
                    header("Content-type: application/force-download");
                    header("Content-transfer-encoding: binary\n");
                    $data = $list->get()->toArray();
                    $out = fopen('php://output', 'w');
                    fputcsv($out, $fields);
                    foreach($data as $line) {
                        fputcsv($out, (array) $line);
                    }
                    fclose($out);
                    die();
            }
            $csvExporter->build($list->get(), $fields)->download();
            die();
        }

        $list = $list->paginate(50);
        return view('home.list', compact('list', 'title', 'id'));
    }
}
