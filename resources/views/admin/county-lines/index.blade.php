@extends('admin.layout')

@section('title', 'County Lines')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-black text-kisii-blue tracking-tight">County Lines</h2>
            <p class="text-sm text-kisii-text-muted mt-1">Manage Kisii County emergency hotlines and support lines.</p>
        </div>
        <a href="{{ route('admin.county-lines.create') }}" class="bg-kisii-blue hover:bg-kisii-blue-dark text-white font-bold px-5 py-3 rounded-2xl transition-all shadow-md">
            + Add Hotline
        </a>
    </div>

    <!-- County Lines Table Card -->
    <div class="bg-white rounded-3xl border border-kisii-border shadow-sm overflow-hidden max-w-4xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-kisii-border text-xs font-bold uppercase tracking-wider text-kisii-text/80">
                        <th class="p-5">Sort</th>
                        <th class="p-5">Label (Carrier / Office)</th>
                        <th class="p-5">Hotline Number</th>
                        <th class="p-5">Status</th>
                        <th class="p-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-kisii-border text-sm">
                    @forelse($lines as $line)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="p-5 font-semibold text-slate-500">{{ $line->sort_order }}</td>
                            <td class="p-5 font-bold text-kisii-text">
                                {{ $line->label }}
                            </td>
                            <td class="p-5 font-mono font-bold text-kisii-blue">
                                {{ $line->number }}
                            </td>
                            <td class="p-5">
                                @if($line->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-800 border border-rose-200">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="p-5 text-right space-x-2">
                                <a href="{{ route('admin.county-lines.edit', $line->id) }}" class="inline-block text-xs font-bold bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200 px-3.5 py-1.5 rounded-xl transition-all">
                                    Edit
                                </a>
                                <form action="{{ route('admin.county-lines.destroy', $line->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this hotline?');">
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
                            <td colspan="5" class="p-10 text-center text-slate-500">
                                <p class="font-bold text-lg">No hotlines configured</p>
                                <p class="text-sm text-slate-400 mt-1">Get started by adding a county line hotline.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
