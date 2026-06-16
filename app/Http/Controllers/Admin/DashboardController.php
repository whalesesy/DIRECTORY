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

        return response()->json(compact('stats', 'recentStaff'));
    }
}
