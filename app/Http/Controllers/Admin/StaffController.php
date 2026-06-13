<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::with('department')->orderBy('department_id')->orderBy('is_senior', 'desc')->orderBy('sort_order')->get();
        return view('admin.staff.index', compact('staff'));
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get();
        return view('admin.staff.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'ext' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'office_message' => 'nullable|string',
            'sort_order' => 'required|integer',
        ]);

        $validated['is_senior'] = $request->has('is_senior');
        $validated['is_active'] = $request->has('is_active');

        // If setting this staff as senior, unset previous senior for this department
        if ($validated['is_senior']) {
            Staff::where('department_id', $validated['department_id'])
                ->where('is_senior', true)
                ->update(['is_senior' => false]);
        }

        Staff::create($validated);

        return redirect()->route('admin.staff.index')->with('success', 'Staff member created successfully.');
    }

    public function edit(Staff $staff)
    {
        $departments = Department::orderBy('name')->get();
        return view('admin.staff.edit', compact('staff', 'departments'));
    }

    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'ext' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'office_message' => 'nullable|string',
            'sort_order' => 'required|integer',
        ]);

        $validated['is_senior'] = $request->has('is_senior');
        $validated['is_active'] = $request->has('is_active');

        // If setting this staff as senior, unset previous senior for this department
        if ($validated['is_senior']) {
            Staff::where('department_id', $validated['department_id'])
                ->where('is_senior', true)
                ->where('id', '!=', $staff->id)
                ->update(['is_senior' => false]);
        }

        $staff->update($validated);

        return redirect()->route('admin.staff.index')->with('success', 'Staff member updated successfully.');
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();
        return redirect()->route('admin.staff.index')->with('success', 'Staff member deleted successfully.');
    }
}
