<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Admin Dashboard') - OneMovies</title>
  <link href="{{ asset('template/css/bootstrap.css') }}" rel="stylesheet">
  <link href="{{ asset('template/css/style.css') }}" rel="stylesheet">
  <style>
    body { padding: 24px 0; }
    .admin-nav { margin-bottom: 24px; padding: 12px 0; border-bottom: 1px solid #ddd; }
    .admin-actions { display: flex; gap: 8px; align-items: center; }
    .admin-actions form { margin: 0; }
    .poster-thumb { width: 60px; height: 85px; object-fit: cover; }
  </style>
</head>
<body>
  <div class="container">
    <div class="admin-nav clearfix">
      <a href="{{ route('admin.dashboard') }}"><strong>OneMovies Admin</strong></a>
      <div class="pull-right admin-actions">
        <a href="{{ route('admin.films.index') }}">Films</a>
        <a href="{{ route('admin.reviews.index') }}">Reviews</a>
        <a href="{{ route('home') }}">View website</a>
        <form action="{{ route('logout') }}" method="post">
          @csrf
          <button class="btn btn-link" type="submit">Logout</button>
        </form>
      </div>
    </div>
    @if (session('status'))
      <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if (session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul style="margin-left:20px">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    @yield('content')
  </div>
</body>
</html>
