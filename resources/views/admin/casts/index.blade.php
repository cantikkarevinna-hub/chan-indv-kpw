@extends('admin.layout')

@section('title', 'Manage Cast')

@section('content')
  <div class="clearfix" style="margin-bottom:20px">
    <h1 class="pull-left">Manage Cast</h1>
    <a class="btn btn-primary pull-right" href="{{ route('admin.casts.create') }}">Add cast member</a>
  </div>

  <div class="table-responsive">
    <table class="table table-striped table-bordered">
      <thead>
        <tr><th>Name</th><th>Age</th><th>Bio</th><th>Actions</th></tr>
      </thead>
      <tbody>
        @forelse ($casts as $cast)
          <tr>
            <td>{{ $cast->name }}</td>
            <td>{{ $cast->age }}</td>
            <td>{{ $cast->bio }}</td>
            <td>
              <div class="admin-actions">
                <a class="btn btn-default btn-sm" href="{{ route('admin.casts.edit', $cast) }}">Edit</a>
                <form action="{{ route('admin.casts.destroy', $cast) }}" method="post" onsubmit="return confirm('Are you sure you want to delete this cast member?')">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="4">No cast members found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $casts->links() }}
@endsection
