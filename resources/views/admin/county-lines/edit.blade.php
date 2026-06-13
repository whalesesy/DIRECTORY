@extends('admin.layout')

@section('title', 'Edit Hotline')

@section('content')
<div class="space-y-6 max-w-2xl">
    <div>
        <h2 class="text-3xl font-black text-kisii-blue tracking-tight">Edit Hotline</h2>
        <p class="text-sm text-kisii-text-muted mt-1">Modify county hotline support line details.</p>
    </div>

    <form action="{{ route('admin.county-lines.update', $countyLine->id) }}" method="POST" class="bg-white rounded-3xl border border-kisii-border p-6 shadow-sm space-y-5">
        @csrf
        @method('PUT')

        @if($errors->any())
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 text-sm rounded-xl">
                Please check the form for errors.
            </div>
        @endif

        <div>
            <label for="label" class="block text-xs font-bold uppercase tracking-wider text-kisii-text/85 mb-2">Label (e.g. Safaricom / Airtel / Disaster Hotline)</label>
            <input type="text" name="label" id="label" required value="{{ old('label', $countyLine->label) }}" placeholder="e.g. Safaricom" class="w-full px-4 py-3 rounded-xl border border-kisii-border focus:outline-none focus:ring-2 focus:ring-kisii-blue/25 focus:border-kisii-blue text-sm shadow-sm transition-all">
            @error('label') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="number" class="block text-xs font-bold uppercase tracking-wider text-kisii-text/85 mb-2">Phone Number</label>
            <input type="text" name="number" id="number" required value="{{ old('number', $countyLine->number) }}" placeholder="e.g. 0709727000" class="w-full px-4 py-3 rounded-xl border border-kisii-border focus:outline-none focus:ring-2 focus:ring-kisii-blue/25 focus:border-kisii-blue text-sm shadow-sm transition-all">
            @error('number') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="sort_order" class="block text-xs font-bold uppercase tracking-wider text-kisii-text/85 mb-2">Sort Order</label>
            <input type="number" name="sort_order" id="sort_order" required value="{{ old('sort_order', $countyLine->sort_order) }}" class="w-full px-4 py-3 rounded-xl border border-kisii-border focus:outline-none focus:ring-2 focus:ring-kisii-blue/25 focus:border-kisii-blue text-sm shadow-sm transition-all">
            @error('sort_order') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-3 pt-2">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $countyLine->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded text-kisii-blue border-kisii-border focus:ring-kisii-blue/25">
            <label for="is_active" class="text-sm font-semibold text-kisii-text">Active (Visible in directory footer)</label>
        </div>

        <div class="flex gap-3 pt-4 border-t border-kisii-border">
            <button type="submit" class="bg-kisii-blue hover:bg-kisii-blue-dark text-white font-bold px-6 py-3 rounded-xl shadow-md transition-all">
                Update Hotline
            </button>
            <a href="{{ route('admin.county-lines.index') }}" class="bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 font-bold px-6 py-3 rounded-xl transition-all">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
