<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFilmRequest;
use App\Http\Requests\UpdateFilmRequest;
use App\Models\Film;
use App\Models\Genre;
use App\Models\Kritik;
use App\Models\Peran;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function movies(Request $request)
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'genre' => ['nullable', 'integer', 'exists:genres,id'],
        ]);

        $query = Film::select('id', 'title', 'poster', 'year')
            ->orderByDesc('year')
            ->orderBy('created_at', 'asc');

        if (! empty($filters['q'])) {
            $search = $filters['q'];
            $query->where(function ($filmQuery) use ($search) {
                $filmQuery->where('title', 'like', "%{$search}%")
                    ->orWhere('sinopsis', 'like', "%{$search}%");
            });
        }

        $genreFilm = null;
        if (! empty($filters['genre'])) {
            $genreFilm = Genre::findOrFail($filters['genre']);
            $query->where('genre_id', $genreFilm->id);
        }

        $films = $query->paginate(18)->withQueryString();
        $genres = Genre::orderBy('name')->get();

        return view('components/movies', compact('films', 'genreFilm', 'genres', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFilmRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Film $film)
    {
        //
        $filmByGenre = Film::select('id', 'title', 'poster', 'year', 'sinopsis')
            ->where('genre_id', '=', $film->genre_id)
            ->OrderBy('created_at', 'asc')
            ->limit(7)
            ->get();
        $filmByRelease = Film::select('id', 'title', 'poster', 'year')
            ->where('year', '=', Carbon::now()->format('Y'))
            ->OrderBy('created_at', 'asc')
            ->limit(9)
            ->get();
        $comments = Kritik::select('comment', 'rating', 'user_id')
            ->where('film_id', '=', $film->id)
            ->with('user:id,name')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(10, ['*'], 'reviews_page')
            ->withQueryString();
        $perans = Peran::with('cast:id,name')
            ->where('film_id', '=', $film->id)
            ->get();

        return view('components.movie-show', compact('film', 'filmByGenre', 'filmByRelease', 'comments', 'perans'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Film $film)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFilmRequest $request, Film $film)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Film $film)
    {
        //
    }

    public function movieHome()
    {
        $films = Film::select('id', 'title', 'poster', 'year')
            ->OrderBy('created_at', 'asc')
            ->limit(9)->get();
        $filmFutured = Film::select('id', 'title', 'poster', 'year')
            ->orderByDesc('year')
            ->OrderBy('created_at', 'asc')
            ->limit(6)->get();
        $filmRecentAdded = Film::select('id', 'title', 'poster', 'year')
            ->orderByDesc('created_at', 'asc')
            ->limit(6)->get();
        $filmSlidey = Film::select('title', 'poster', 'sinopsis')
            ->orderByDesc('year')
            ->OrderBy('created_at', 'asc')
            ->limit(6)->get();

        return view('components/home', compact('filmSlidey', 'films', 'filmFutured', 'filmRecentAdded'));
    }

    public function moviesByGenre($genre)
    {
        $genreFilm = Genre::findOrFail($genre);
        $films = Film::select('id', 'title', 'poster', 'year')
            ->where('genre_id', $genreFilm->id)
            ->orderByDesc('year')
            ->orderBy('created_at', 'asc')
            ->paginate(18)
            ->withQueryString();
        $genres = Genre::orderBy('name')->get();
        $filters = ['q' => '', 'genre' => $genreFilm->id];

        return view('components/movies', compact('films', 'genreFilm', 'genres', 'filters'));
    }
}
