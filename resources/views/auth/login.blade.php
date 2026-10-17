@extends('auth.layout')

@section('title', 'Login')
@section('heading', 'Sign in to your account')

@section('content')
  <form action="{{ route('login.store') }}" method="post">
    @csrf
    <label for="email">Email</label>
    <input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required autofocus>

    <label for="password">Password</label>
    <input class="form-control" id="password" type="password" name="password" autocomplete="current-password" required>

    <label><input type="checkbox" name="remember" value="1"> Remember me</label>
    <button class="btn btn-primary btn-block" type="submit">Login</button>
  </form>
  <p style="margin-top:18px">Don't have an account? <a href="{{ route('register') }}">Register</a></p>
@endsection
