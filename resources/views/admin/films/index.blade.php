@extends('admin.layout')

@section('title', 'Manage Films')

@section('content')
  <div class="clearfix" style="margin-bottom:20px">
    <h1 class="pull-left">Manage Films</h1>
    <a class="btn btn-primary pull-right" href="{{ route('admin.films.create') }}">Add film</a>
  </div>

  <div class="table-responsive">
    <table class="table table-striped table-bordered">
      <thead>
        <tr><th>Poster</th><th>Title</th><th>Year</th><th>Genre</th><th>Actions</th></tr>
      </thead>
      <tbody>
        @forelse ($films as $film)
          <tr>
            <td><img class="poster-thumb" src="{{ asset($film->poster) }}" alt="Poster {{ $film->title }}"></td>
            <td>{{ $film->title }}</td>
            <td>{{ $film->year }}</td>
            <td>{{ $film->genre->name }}</td>
            <td>
              <div class="admin-actions">
                <a class="btn btn-default btn-sm" href="{{ route('admin.films.edit', $film) }}">Edit</a>
                <form action="{{ route('admin.films.destroy', $film) }}" method="post" onsubmit="return confirm('Are you sure you want to delete this film?')">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="5">No films found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  {{ $films->links() }}
@endsection
