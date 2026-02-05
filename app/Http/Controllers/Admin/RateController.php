<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RateController extends Controller
{
    public function index(): View
    {
        $rates = Rate::orderByDesc('season_start')->get();

        return view('admin.rates.index', compact('rates'));
    }

    public function create(): View
    {
        return view('admin.rates.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'season_start' => ['nullable', 'date'],
            'season_end' => ['nullable', 'date', 'after_or_equal:season_start'],
            'notes' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        Rate::create($data);

        return redirect()->route('admin.rates.index')->with('success', 'Rate created.');
    }

    public function edit(Rate $rate): View
    {
        return view('admin.rates.edit', compact('rate'));
    }

    public function update(Request $request, Rate $rate): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'season_start' => ['nullable', 'date'],
            'season_end' => ['nullable', 'date', 'after_or_equal:season_start'],
            'notes' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $rate->update($data);

        return back()->with('success', 'Rate updated.');
    }

    public function destroy(Rate $rate): RedirectResponse
    {
        $rate->delete();

        return redirect()->route('admin.rates.index')->with('success', 'Rate removed.');
    }
}
