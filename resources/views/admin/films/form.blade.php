@extends('admin.layout')

@section('title', $film->exists ? 'Edit Film' : 'Add Film')

@section('content')
  <h1>{{ $film->exists ? 'Edit Film' : 'Add Film' }}</h1>

  <form action="{{ $film->exists ? route('admin.films.update', $film) : route('admin.films.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    @if ($film->exists)
      @method('PUT')
    @endif

    <div class="form-group">
      <label for="title">Title</label>
      <input class="form-control" id="title" type="text" name="title" value="{{ old('title', $film->title) }}" required>
    </div>
    <div class="form-group">
      <label for="sinopsis">Synopsis</label>
      <textarea class="form-control" id="sinopsis" name="sinopsis" rows="5" required>{{ old('sinopsis', $film->sinopsis) }}</textarea>
    </div>
    <div class="form-group">
      <label for="year">Year</label>
      <input class="form-control" id="year" type="number" name="year" min="1888" max="{{ now()->year + 5 }}" value="{{ old('year', $film->year) }}" required>
    </div>
    <div class="form-group">
      <label for="genre_id">Genre</label>
      <select class="form-control" id="genre_id" name="genre_id" required>
        <option value="">Select a genre</option>
        @foreach ($genres as $genre)
          <option value="{{ $genre->id }}" @selected((string) old('genre_id', $film->genre_id) === (string) $genre->id)>{{ $genre->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label for="poster">Poster {{ $film->exists ? '(leave blank to keep the current poster)' : '' }}</label>
      <input class="form-control" id="poster" type="file" name="poster" accept="image/*" @required(!$film->exists)>
      @if ($film->exists)
        <img class="poster-thumb" src="{{ asset($film->poster) }}" alt="Poster {{ $film->title }}">
      @endif
      <p class="help-block">Image files only, up to 5 MB.</p>
    </div>

    <button class="btn btn-primary" type="submit">Save</button>
    <a class="btn btn-default" href="{{ route('admin.films.index') }}">Cancel</a>
  </form>
@endsection
