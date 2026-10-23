@extends('admin.layout')

@section('title', $cast->exists ? 'Edit Cast Member' : 'Add Cast Member')

@section('content')
  <h1>{{ $cast->exists ? 'Edit Cast Member' : 'Add Cast Member' }}</h1>

  <form action="{{ $cast->exists ? route('admin.casts.update', $cast) : route('admin.casts.store') }}" method="post">
    @csrf
    @if ($cast->exists)
      @method('PUT')
    @endif

    <div class="form-group">
      <label for="cast-name">Name</label>
      <input class="form-control" id="cast-name" name="name" type="text" maxlength="45" value="{{ old('name', $cast->name) }}" required>
    </div>
    <div class="form-group">
      <label for="cast-age">Age</label>
      <input class="form-control" id="cast-age" name="age" type="number" min="1" max="120" value="{{ old('age', $cast->age) }}" required>
    </div>
    <div class="form-group">
      <label for="cast-bio">Bio</label>
      <textarea class="form-control" id="cast-bio" name="bio" rows="5" required>{{ old('bio', $cast->bio) }}</textarea>
    </div>

    <button class="btn btn-primary" type="submit">{{ $cast->exists ? 'Save changes' : 'Add cast member' }}</button>
    <a class="btn btn-default" href="{{ route('admin.casts.index') }}">Cancel</a>
  </form>
@endsection
