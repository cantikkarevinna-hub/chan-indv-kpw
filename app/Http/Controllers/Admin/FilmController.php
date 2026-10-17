<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Genre;
use App\Models\Kritik;
use App\Models\Peran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use RuntimeException;

class FilmController extends Controller
{
    public function index(): View
    {
        return view('admin.films.index', [
            'films' => Film::with('genre')->orderByDesc('created_at')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.films.form', [
            'film' => new Film,
            'genres' => Genre::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());
        $validated['poster'] = $this->storePoster($request);

        Film::create($validated);

        return redirect()->route('admin.films.index')->with('status', 'Film added successfully.');
    }

    public function edit(Film $film): View
    {
        return view('admin.films.form', [
            'film' => $film,
            'genres' => Genre::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Film $film): RedirectResponse
    {
        $validated = $request->validate($this->rules(false));

        if ($request->hasFile('poster')) {
            $validated['poster'] = $this->storePoster($request);
        }

        $oldPoster = $request->hasFile('poster') ? $film->getRawOriginal('poster') : null;
        $film->update($validated);
        $this->deleteUploadedPoster($oldPoster);

        return redirect()->route('admin.films.index')->with('status', 'Film updated successfully.');
    }

    public function destroy(Film $film): RedirectResponse
    {
        if (Kritik::where('film_id', $film->id)->exists() || Peran::where('film_id', $film->id)->exists()) {
            return back()->with('error', 'This film still has reviews or cast records. Delete the related records first.');
        }

        $poster = $film->getRawOriginal('poster');
        $film->delete();
        $this->deleteUploadedPoster($poster);

        return redirect()->route('admin.films.index')->with('status', 'Film deleted successfully.');
    }

    private function rules(bool $posterRequired = true): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'sinopsis' => ['required', 'string'],
            'year' => ['required', 'integer', 'min:1888', 'max:'.(now()->year + 5)],
            'genre_id' => ['required', 'integer', 'exists:genres,id'],
            'poster' => [$posterRequired ? 'required' : 'nullable', 'image', 'max:5120'],
        ];
    }

    private function storePoster(Request $request): string
    {
        $path = $request->file('poster')->store('posters', 'public');

        if ($path === false) {
            throw new RuntimeException('The film poster could not be saved.');
        }

        return 'storage/'.$path;
    }

    private function deleteUploadedPoster(?string $poster): void
    {
        if ($poster !== null && str_starts_with($poster, 'storage/posters/')) {
            if (! Storage::disk('public')->delete(substr($poster, strlen('storage/')))) {
                throw new RuntimeException('The old poster could not be deleted from storage.');
            }
        }
    }
}
