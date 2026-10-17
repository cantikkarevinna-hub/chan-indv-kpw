@extends('auth.layout')

@section('title', 'Register')
@section('heading', 'Create a new account')

@section('content')
  <form action="{{ route('register.store') }}" method="post">
    @csrf
    <label for="name">Name</label>
    <input class="form-control" id="name" type="text" name="name" value="{{ old('name') }}" autocomplete="name" required>

    <label for="email">Email</label>
    <input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required>

    <label for="password">Password (at least 8 characters)</label>
    <input class="form-control" id="password" type="password" name="password" autocomplete="new-password" required>

    <label for="password_confirmation">Confirm password</label>
    <input class="form-control" id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" required>

    <button class="btn btn-primary btn-block" type="submit">Register</button>
  </form>
  <p style="margin-top:18px">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
@endsection
