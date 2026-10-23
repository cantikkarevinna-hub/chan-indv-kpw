@extends('templates.index')

@section('content')
  <style>
    .profile-card {
      max-width: 820px;
      margin: 32px auto 48px;
      border: 1px solid #e5e5e5;
      border-radius: 8px;
      box-shadow: 0 4px 18px rgba(0, 0, 0, .08);
      overflow: hidden;
    }
    .profile-card-heading { padding: 24px 30px; }
    .profile-card-heading h2 { margin: 0; font-size: 28px; }
    .profile-card-body { padding: 32px; background: #fafafa; }
    .profile-avatar {
      width: 128px;
      height: 128px;
      margin: 0 auto;
      border: 3px solid #ff8d1b;
      border-radius: 50%;
      object-fit: cover;
    }
    .profile-details { margin: 0; }
    .profile-detail {
      display: grid;
      grid-template-columns: 110px minmax(0, 1fr);
      gap: 18px;
      padding: 13px 0;
      border-bottom: 1px solid #e6e6e6;
      font-size: 17px;
      line-height: 1.5;
    }
    .profile-detail:last-child { border-bottom: 0; }
    .profile-detail dt { color: #444; font-weight: 600; }
    .profile-detail dd { margin: 0; color: #666; overflow-wrap: anywhere; }
    .profile-card-actions { margin-top: 24px; }
    @media (max-width: 600px) {
      .profile-card-body { padding: 22px; }
      .profile-detail { grid-template-columns: 1fr; gap: 3px; font-size: 16px; }
    }
  </style>
  <div class="container">
    <div class="agileits-single-top">
      <ol class="breadcrumb">
        <li><a href="{{ route('home') }}">Home</a></li>
        <li class="active">My Profile</li>
      </ol>
    </div>

    @if (session('status'))
      <div class="alert alert-success" role="status">{{ session('status') }}</div>
    @endif

    <section class="profile-card">
      <div class="profile-card-heading">
        <h2>My Profile</h2>
      </div>
      <div class="profile-card-body">
        <div class="row">
          <div class="col-sm-4 text-center">
            <img
              src="{{ asset('template/images/user.jpg') }}"
              alt="{{ $user->name }}"
              class="profile-avatar"
            >
          </div>
          <div class="col-sm-8">
            <dl class="profile-details">
              <div class="profile-detail">
                <dt>Email</dt>
                <dd>{{ $user->email }}</dd>
              </div>
              <div class="profile-detail">
                <dt>Age</dt>
                <dd>{{ $user->profile?->umur ?: 'Not provided' }}</dd>
              </div>
              <div class="profile-detail">
                <dt>Bio</dt>
                <dd>{{ $user->profile?->bio ?: 'Not provided' }}</dd>
              </div>
            </dl>
            <div class="profile-card-actions">
              <a class="btn btn-primary" href="{{ route('profile.edit') }}">Edit profile</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
