<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CountyLine;
use App\Models\Department;
use App\Models\Staff;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'departments_count' => Department::count(),
            'staff_count' => Staff::count(),
            'county_lines_count' => CountyLine::count(),
        ];

        $recentStaff = Staff::with('department')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentStaff'));
    }

    public function updates()
    {
        return response()->stream(function () {
            while (true) {
                if (connection_aborted()) {
                    break;
                }

                $stats = [
                    'departments_count' => Department::count(),
                    'staff_count' => Staff::count(),
                    'county_lines_count' => CountyLine::count(),
                ];

                $recentStaff = Staff::with('department')
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get()
                    ->map(function ($staff) {
                        return [
                            'name' => $staff->name,
                            'role' => $staff->role,
                            'department' => $staff->department->name,
                            'ext' => $staff->ext ?? 'None',
                        ];
                    });

                echo "data: " . json_encode(compact('stats', 'recentStaff')) . "\n\n";
                ob_flush();
                flush();

                if (app()->environment('testing')) {
                    break;
                }

                sleep(3);
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering' => 'no',
        ]);
    }
}
