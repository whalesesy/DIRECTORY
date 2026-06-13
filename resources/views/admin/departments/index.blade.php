@extends('admin.layout')

@section('title', 'Departments')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-black text-kisii-blue tracking-tight">Departments</h2>
            <p class="text-sm text-kisii-text-muted mt-1">Manage Kisii County ministries, agencies, and offices.</p>
        </div>
        <a href="{{ route('admin.departments.create') }}" class="bg-kisii-blue hover:bg-kisii-blue-dark text-white font-bold px-5 py-3 rounded-2xl transition-all shadow-md">
            + Add Department
        </a>
    </div>

    <!-- Departments Table Card -->
    <div class="bg-white rounded-3xl border border-kisii-border shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-kisii-border text-xs font-bold uppercase tracking-wider text-kisii-text/80">
                        <th class="p-5">Sort</th>
                        <th class="p-5">Slug</th>
                        <th class="p-5">Department Name</th>
                        <th class="p-5">Icon</th>
                        <th class="p-5">Accent Color</th>
                        <th class="p-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-kisii-border text-sm">
                    @foreach($departments as $dept)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="p-5 font-semibold text-slate-500">{{ $dept->sort_order }}</td>
                            <td class="p-5 font-mono text-xs">{{ $dept->slug }}</td>
                            <td class="p-5 font-bold text-kisii-text">
                                {{ $dept->name }}
                                @if(!$dept->is_active)
                                    <span class="ml-2 text-xs font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-500">Inactive</span>
                                @endif
                            </td>
                            <td class="p-5">
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 font-mono text-xs text-slate-700">{{ $dept->icon }}</span>
                            </td>
                            <td class="p-5 flex items-center gap-2">
                                <span class="w-4 h-4 rounded-full border border-slate-200" style="background-color: {{ $dept->accent_color }}"></span>
                                <span class="font-mono text-xs">{{ $dept->accent_color }}</span>
                            </td>
                            <td class="p-5 text-right space-x-2">
                                <a href="{{ route('admin.departments.edit', $dept->id) }}" class="inline-block text-xs font-bold bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200 px-3.5 py-1.5 rounded-xl transition-all">
                                    Edit
                                </a>
                                <form action="{{ route('admin.departments.destroy', $dept->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this department? All associated staff will be deleted.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-bold bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 px-3.5 py-1.5 rounded-xl transition-all">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
