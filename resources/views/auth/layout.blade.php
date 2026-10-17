<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title') - OneMovies</title>
  <link href="{{ asset('template/css/bootstrap.css') }}" rel="stylesheet">
  <link href="{{ asset('template/css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('template/css/contactstyle.css') }}" rel="stylesheet">
  <style>
    .auth-page { max-width: 480px; margin: 50px auto; padding: 30px; border: 1px solid #ddd; }
    .auth-page .form-control { margin: 8px 0 16px; }
    .auth-page .btn { background: #ff8d1b; border-color: #ff8d1b; color: #fff; }
  </style>
</head>
<body>
  <div class="container">
    <div class="auth-page">
      <h2><a href="{{ route('home') }}">One<span>Movies</span></a></h2>
      <h3>@yield('heading')</h3>
      @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
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
  </div>
</body>
</html>
