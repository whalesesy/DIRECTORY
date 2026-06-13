<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CountyLine;
use Illuminate\Http\Request;

class CountyLineController extends Controller
{
    public function index()
    {
        $lines = CountyLine::orderBy('sort_order')->get();
        return view('admin.county-lines.index', compact('lines'));
    }

    public function create()
    {
        return view('admin.county-lines.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'number' => 'required|string|max:255',
            'sort_order' => 'required|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');

        CountyLine::create($validated);

        return redirect()->route('admin.county-lines.index')->with('success', 'County line created successfully.');
    }

    public function edit(CountyLine $countyLine)
    {
        return view('admin.county-lines.edit', compact('countyLine'));
    }

    public function update(Request $request, CountyLine $countyLine)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'number' => 'required|string|max:255',
            'sort_order' => 'required|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $countyLine->update($validated);

        return redirect()->route('admin.county-lines.index')->with('success', 'County line updated successfully.');
    }

    public function destroy(CountyLine $countyLine)
    {
        $countyLine->delete();
        return redirect()->route('admin.county-lines.index')->with('success', 'County line deleted successfully.');
    }
}
