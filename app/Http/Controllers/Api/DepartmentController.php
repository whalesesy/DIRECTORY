<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $data = cache()->remember('api.departments', 3600, function () {
            $departments = Department::where('is_active', true)
                ->with(['senior', 'staff'])
                ->orderBy('sort_order')
                ->get();
            return DepartmentResource::collection($departments)->response()->getData(true)['data'];
        });

        return response()->json(['data' => $data]);
    }

    public function show(string $slug)
    {
        $departmentsData = cache()->remember('api.departments', 3600, function () {
            $departments = Department::where('is_active', true)
                ->with(['senior', 'staff'])
                ->orderBy('sort_order')
                ->get();
            return DepartmentResource::collection($departments)->response()->getData(true)['data'];
        });

        $department = collect($departmentsData)->first(function ($item) use ($slug) {
            return ($item['id'] ?? '') === $slug;
        });

        if (!$department) {
            abort(404);
        }

        return response()->json(['data' => $department]);
    }
}
