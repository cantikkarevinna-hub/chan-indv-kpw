@extends('templates.index')

@section('content')
  <div class="container">
    <div class="agileits-single-top">
      <ol class="breadcrumb">
        <li><a href="{{ route('home') }}">Home</a></li>
        <li class="active">My Profile</li>
      </ol>
    </div>

    <div class="panel panel-default" style="max-width:720px;margin:24px auto">
      <div class="panel-heading">
        <h2>My Profile</h2>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-sm-3 text-center">
            <img
              src="{{ asset('template/images/user.jpg') }}"
              alt="{{ $user->name }}"
              style="width:96px;height:96px;border-radius:50%;object-fit:cover"
            >
          </div>
          <div class="col-sm-9">
            <dl class="dl-horizontal">
              <dt>Name</dt>
              <dd>{{ $user->name }}</dd>
              <dt>Email</dt>
              <dd>{{ $user->email }}</dd>
              <dt>Age</dt>
              <dd>{{ $user->profile?->umur ?: 'Not provided' }}</dd>
              <dt>Bio</dt>
              <dd>{{ $user->profile?->bio ?: 'Not provided' }}</dd>
              <dt>Address</dt>
              <dd>{{ $user->profile?->alamat ?: 'Not provided' }}</dd>
            </dl>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
