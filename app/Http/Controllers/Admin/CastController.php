<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCastRequest;
use App\Http\Requests\UpdateCastRequest;
use App\Models\Cast;
use App\Models\Peran;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CastController extends Controller
{
    public function index(): View
    {
        return view('admin.casts.index', [
            'casts' => Cast::orderBy('name')->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.casts.form', ['cast' => new Cast]);
    }

    public function store(StoreCastRequest $request): RedirectResponse
    {
        Cast::create($request->validated());

        return redirect()->route('admin.casts.index')->with('status', 'Cast added successfully.');
    }

    public function edit(Cast $cast): View
    {
        return view('admin.casts.form', compact('cast'));
    }

    public function update(UpdateCastRequest $request, Cast $cast): RedirectResponse
    {
        $cast->update($request->validated());

        return redirect()->route('admin.casts.index')->with('status', 'Cast updated successfully.');
    }

    public function destroy(Cast $cast): RedirectResponse
    {
        if (Peran::where('cast_id', $cast->id)->exists()) {
            return back()->with('error', 'This cast member is assigned to a film and cannot be deleted.');
        }

        $cast->delete();

        return redirect()->route('admin.casts.index')->with('status', 'Cast deleted successfully.');
    }
}
