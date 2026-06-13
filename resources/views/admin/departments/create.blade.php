@extends('admin.layout')

@section('title', 'Add Department')

@section('content')
<div class="space-y-6 max-w-2xl">
    <div>
        <h2 class="text-3xl font-black text-kisii-blue tracking-tight">Add Department</h2>
        <p class="text-sm text-kisii-text-muted mt-1">Create a new county government department.</p>
    </div>

    <form action="{{ route('admin.departments.store') }}" method="POST" class="bg-white rounded-3xl border border-kisii-border p-6 shadow-sm space-y-5">
        @csrf

        @if($errors->any())
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 text-sm rounded-xl">
                Please check the form for errors.
            </div>
        @endif

        <div>
            <label for="name" class="block text-xs font-bold uppercase tracking-wider text-kisii-text/85 mb-2">Department Full Name</label>
            <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="e.g. Health & Sanitation" class="w-full px-4 py-3 rounded-xl border border-kisii-border focus:outline-none focus:ring-2 focus:ring-kisii-blue/25 focus:border-kisii-blue text-sm shadow-sm transition-all">
            @error('name') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="short_name" class="block text-xs font-bold uppercase tracking-wider text-kisii-text/85 mb-2">Short Name (for lists)</label>
            <input type="text" name="short_name" id="short_name" required value="{{ old('short_name') }}" placeholder="e.g. Health" class="w-full px-4 py-3 rounded-xl border border-kisii-border focus:outline-none focus:ring-2 focus:ring-kisii-blue/25 focus:border-kisii-blue text-sm shadow-sm transition-all">
            @error('short_name') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="icon" class="block text-xs font-bold uppercase tracking-wider text-kisii-text/85 mb-2">Lucide Icon Name</label>
                <input type="text" name="icon" id="icon" required value="{{ old('icon') }}" placeholder="e.g. Heart" class="w-full px-4 py-3 rounded-xl border border-kisii-border focus:outline-none focus:ring-2 focus:ring-kisii-blue/25 focus:border-kisii-blue text-sm shadow-sm transition-all">
                @error('icon') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="accent_color" class="block text-xs font-bold uppercase tracking-wider text-kisii-text/85 mb-2">Accent Hex Color</label>
                <input type="text" name="accent_color" id="accent_color" required value="{{ old('accent_color', '#1B4F8A') }}" placeholder="e.g. #1B4F8A" class="w-full px-4 py-3 rounded-xl border border-kisii-border focus:outline-none focus:ring-2 focus:ring-kisii-blue/25 focus:border-kisii-blue text-sm shadow-sm transition-all">
                @error('accent_color') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="sort_order" class="block text-xs font-bold uppercase tracking-wider text-kisii-text/85 mb-2">Sort Order</label>
            <input type="number" name="sort_order" id="sort_order" required value="{{ old('sort_order', 0) }}" class="w-full px-4 py-3 rounded-xl border border-kisii-border focus:outline-none focus:ring-2 focus:ring-kisii-blue/25 focus:border-kisii-blue text-sm shadow-sm transition-all">
            @error('sort_order') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-3 pt-2">
            <input type="checkbox" name="is_active" id="is_active" value="1" checked class="w-4 h-4 rounded text-kisii-blue border-kisii-border focus:ring-kisii-blue/25">
            <label for="is_active" class="text-sm font-semibold text-kisii-text">Active (Visible on directory)</label>
        </div>

        <div class="flex gap-3 pt-4 border-t border-kisii-border">
            <button type="submit" class="bg-kisii-blue hover:bg-kisii-blue-dark text-white font-bold px-6 py-3 rounded-xl shadow-md transition-all">
                Save Department
            </button>
            <a href="{{ route('admin.departments.index') }}" class="bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 font-bold px-6 py-3 rounded-xl transition-all">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
