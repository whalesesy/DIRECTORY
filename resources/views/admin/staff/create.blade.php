@extends('admin.layout')

@section('title', 'Add Staff Member')

@section('content')
<div class="space-y-6 max-w-2xl">
    <div>
        <h2 class="text-3xl font-black text-kisii-blue tracking-tight">Add Staff Member</h2>
        <p class="text-sm text-kisii-text-muted mt-1">Create a new contact record for the county directory.</p>
    </div>

    <form action="{{ route('admin.staff.store') }}" method="POST" class="bg-white rounded-3xl border border-kisii-border p-6 shadow-sm space-y-5">
        @csrf

        @if($errors->any())
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 text-sm rounded-xl">
                Please check the form for errors.
            </div>
        @endif

        <div>
            <label for="department_id" class="block text-xs font-bold uppercase tracking-wider text-kisii-text/85 mb-2">Department</label>
            <select name="department_id" id="department_id" required class="w-full px-4 py-3 rounded-xl border border-kisii-border focus:outline-none focus:ring-2 focus:ring-kisii-blue/25 focus:border-kisii-blue text-sm shadow-sm transition-all bg-white">
                <option value="" disabled selected>Select a Department...</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                        {{ $dept->name }}
                    </option>
                @endforeach
            </select>
            @error('department_id') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="name" class="block text-xs font-bold uppercase tracking-wider text-kisii-text/85 mb-2">Staff Member Name</label>
            <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="e.g. Susan Nyamweya" class="w-full px-4 py-3 rounded-xl border border-kisii-border focus:outline-none focus:ring-2 focus:ring-kisii-blue/25 focus:border-kisii-blue text-sm shadow-sm transition-all">
            @error('name') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="role" class="block text-xs font-bold uppercase tracking-wider text-kisii-text/85 mb-2">Role / Title</label>
            <input type="text" name="role" id="role" required value="{{ old('role') }}" placeholder="e.g. Chief of Staff" class="w-full px-4 py-3 rounded-xl border border-kisii-border focus:outline-none focus:ring-2 focus:ring-kisii-blue/25 focus:border-kisii-blue text-sm shadow-sm transition-all">
            @error('role') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="ext" class="block text-xs font-bold uppercase tracking-wider text-kisii-text/85 mb-2">Extension (Optional)</label>
                <input type="text" name="ext" id="ext" value="{{ old('ext') }}" placeholder="e.g. 101" class="w-full px-4 py-3 rounded-xl border border-kisii-border focus:outline-none focus:ring-2 focus:ring-kisii-blue/25 focus:border-kisii-blue text-sm shadow-sm transition-all">
                @error('ext') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="sort_order" class="block text-xs font-bold uppercase tracking-wider text-kisii-text/85 mb-2">Sort Order</label>
                <input type="number" name="sort_order" id="sort_order" required value="{{ old('sort_order', 0) }}" class="w-full px-4 py-3 rounded-xl border border-kisii-border focus:outline-none focus:ring-2 focus:ring-kisii-blue/25 focus:border-kisii-blue text-sm shadow-sm transition-all">
                @error('sort_order') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="border-t border-kisii-border pt-4 space-y-4">
            <h4 class="text-xs font-black uppercase tracking-wider text-kisii-text">Senior Role Options</h4>
            <p class="text-xs text-kisii-text-muted">Fields below are primarily displayed for Senior department leadership (e.g. Chief Officers, Governors).</p>

            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-kisii-text/85 mb-2">Email (Optional)</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="e.g. officer@kisii.go.ke" class="w-full px-4 py-3 rounded-xl border border-kisii-border focus:outline-none focus:ring-2 focus:ring-kisii-blue/25 focus:border-kisii-blue text-sm shadow-sm transition-all">
                @error('email') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="office_message" class="block text-xs font-bold uppercase tracking-wider text-kisii-text/85 mb-2">Office Message / Vision (Optional)</label>
                <textarea name="office_message" id="office_message" rows="3" placeholder="A short statement from this office..." class="w-full px-4 py-3 rounded-xl border border-kisii-border focus:outline-none focus:ring-2 focus:ring-kisii-blue/25 focus:border-kisii-blue text-sm shadow-sm transition-all">{{ old('office_message') }}</textarea>
                @error('office_message') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 pt-2 border-t border-kisii-border">
            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_senior" id="is_senior" value="1" {{ old('is_senior') ? 'checked' : '' }} class="w-4 h-4 rounded text-kisii-blue border-kisii-border focus:ring-kisii-blue/25">
                <label for="is_senior" class="text-sm font-semibold text-kisii-text">⭐ Mark as Senior Leader</label>
            </div>
            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_active" id="is_active" value="1" checked class="w-4 h-4 rounded text-kisii-blue border-kisii-border focus:ring-kisii-blue/25">
                <label for="is_active" class="text-sm font-semibold text-kisii-text">Active (Visible in Directory)</label>
            </div>
        </div>

        <div class="flex gap-3 pt-4 border-t border-kisii-border">
            <button type="submit" class="bg-kisii-blue hover:bg-kisii-blue-dark text-white font-bold px-6 py-3 rounded-xl shadow-md transition-all">
                Save Staff Member
            </button>
            <a href="{{ route('admin.staff.index') }}" class="bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 font-bold px-6 py-3 rounded-xl transition-all">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
