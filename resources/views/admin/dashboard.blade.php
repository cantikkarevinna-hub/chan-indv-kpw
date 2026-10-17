@extends('admin.layout')

@section('content')
  <h1>Admin Dashboard</h1>
  <p>Welcome, {{ auth()->user()->name }}.</p>

  <div class="row" style="margin-top:24px">
    <div class="col-sm-4"><div class="panel panel-default"><div class="panel-body"><h3>{{ $filmCount }}</h3>Films</div></div></div>
    <div class="col-sm-4"><div class="panel panel-default"><div class="panel-body"><h3>{{ $genreCount }}</h3>Genres</div></div></div>
    <div class="col-sm-4"><div class="panel panel-default"><div class="panel-body"><h3>{{ $userCount }}</h3>Users</div></div></div>
    <div class="col-sm-4"><div class="panel panel-default"><div class="panel-body"><h3>{{ $reviewCount }}</h3>Reviews</div></div></div>
  </div>

  <a class="btn btn-primary" href="{{ route('admin.films.index') }}">Manage films</a>
  <a class="btn btn-default" href="{{ route('admin.reviews.index') }}">Manage reviews</a>
@endsection
