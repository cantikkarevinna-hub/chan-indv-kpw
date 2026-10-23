@extends('templates.index')

@section('content')
  <div class="container">
    <div class="agileits-single-top">
      <ol class="breadcrumb">
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('profile.me') }}">My Profile</a></li>
        <li class="active">Edit Profile</li>
      </ol>
    </div>

    <div class="panel panel-default" style="max-width:760px;margin:32px auto">
      <div class="panel-heading">
        <h2 style="margin:8px 0">Edit Profile</h2>
      </div>
      <div class="panel-body" style="padding:28px">
        @if ($errors->any())
          <div class="alert alert-danger" role="alert">
            <ul style="margin:0;padding-left:20px">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('profile.update') }}" method="post">
          @csrf
          @method('PUT')

          <div class="form-group">
            <label for="profile-email">Email</label>
            <input class="form-control input-lg" id="profile-email" name="email" type="email" value="{{ old('email', $user->email) }}" required>
          </div>
          <div class="form-group">
            <label for="profile-age">Age</label>
            <input class="form-control input-lg" id="profile-age" name="umur" type="number" min="0" max="120" value="{{ old('umur', $user->profile?->umur ?? 0) }}" required>
          </div>
          <div class="form-group">
            <label for="profile-bio">Bio</label>
            <textarea class="form-control" id="profile-bio" name="bio" rows="5" maxlength="2000">{{ old('bio', $user->profile?->bio) }}</textarea>
          </div>

          <button class="btn btn-primary" type="submit">Save changes</button>
          <a class="btn btn-default" href="{{ route('profile.me') }}">Cancel</a>
        </form>
      </div>
    </div>
  </div>
@endsection
