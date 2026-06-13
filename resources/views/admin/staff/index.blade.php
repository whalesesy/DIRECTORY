@extends('admin.layout')

@section('title', 'Staff Directory')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black text-kisii-blue tracking-tight">Staff Directory</h2>
            <p class="text-sm text-kisii-text-muted mt-1">Manage Kisii County directory personnel and contact extensions.</p>
        </div>
        <a href="{{ route('admin.staff.create') }}" class="inline-flex items-center justify-center bg-kisii-green hover:bg-kisii-green/90 text-white font-bold px-5 py-3 rounded-2xl transition-all shadow-md">
            + Add Staff Member
        </a>
    </div>

    <!-- Staff Table Card -->
    <div class="bg-white rounded-3xl border border-kisii-border shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-kisii-border text-xs font-bold uppercase tracking-wider text-kisii-text/80">
                        <th class="p-5">Name</th>
                        <th class="p-5">Role</th>
                        <th class="p-5">Department</th>
                        <th class="p-5">Extension</th>
                        <th class="p-5">Contact / Email</th>
                        <th class="p-5">Seniority</th>
                        <th class="p-5">Status</th>
                        <th class="p-5">Sort</th>
                        <th class="p-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-kisii-border text-sm">
                    @forelse($staff as $member)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="p-5 font-bold text-kisii-text">
                                {{ $member->name }}
                            </td>
                            <td class="p-5 text-slate-700">
                                {{ $member->role }}
                            </td>
                            <td class="p-5">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold" style="background-color: {{ $member->department->accent_color }}20; color: {{ $member->department->accent_color }}">
                                    {{ $member->department->short_name }}
                                </span>
                            </td>
                            <td class="p-5">
                                @if($member->ext)
                                    <span class="px-2.5 py-1 rounded-lg bg-slate-100 font-mono text-xs text-slate-700">Ext: {{ $member->ext }}</span>
                                @else
                                    <span class="text-slate-400 text-xs italic">None</span>
                                @endif
                            </td>
                            <td class="p-5">
                                @if($member->email)
                                    <a href="mailto:{{ $member->email }}" class="text-xs text-kisii-blue hover:underline">{{ $member->email }}</a>
                                @else
                                    <span class="text-slate-400 text-xs italic">-</span>
                                @endif
                            </td>
                            <td class="p-5">
                                @if($member->is_senior)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-800 border border-amber-200">
                                        ⭐ Senior
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                                        Regular
                                    </span>
                                @endif
                            </td>
                            <td class="p-5">
                                @if($member->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-800 border border-rose-200">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="p-5 font-semibold text-slate-500">
                                {{ $member->sort_order }}
                            </td>
                            <td class="p-5 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('admin.staff.edit', $member->id) }}" class="inline-block text-xs font-bold bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200 px-3.5 py-1.5 rounded-xl transition-all">
                                    Edit
                                </a>
                                <form action="{{ route('admin.staff.destroy', $member->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this staff member?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-bold bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 px-3.5 py-1.5 rounded-xl transition-all">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="p-10 text-center text-slate-500">
                                <p class="font-bold text-lg">No staff members found</p>
                                <p class="text-sm text-slate-400 mt-1">Get started by adding a new staff member to a department.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
