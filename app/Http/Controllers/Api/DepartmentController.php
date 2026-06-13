<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::where('is_active', true)
            ->with(['senior', 'staff'])
            ->orderBy('sort_order')
            ->get();

        return DepartmentResource::collection($departments);
    }

    public function show(string $slug)
    {
        $department = Department::where('slug', $slug)
            ->where('is_active', true)
            ->with(['senior', 'staff'])
            ->firstOrFail();

        return new DepartmentResource($department);
    }
}
