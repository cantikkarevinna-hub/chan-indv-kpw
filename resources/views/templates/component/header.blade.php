<div class="header">
  <div class="container">
    <div class="w3layouts_logo">
      <a href="{{ route('home') }}"><h1>One<span>Movies</span></h1></a>
    </div>
    <div class="w3_search">
      <form action="{{ route('movies') }}" method="get">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search movies..." aria-label="Search movies">
        <input type="submit" value="Go">
      </form>
    </div>
    <div class="w3l_sign_in_register">
      <ul>
        @auth
          <li class="dropdown account-menu">
            <button class="account-menu-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="Open account menu">
              <img src="{{ asset('template/images/user.jpg') }}" alt="">
              <span class="sr-only">{{ auth()->user()->name }}</span>
              <i class="fa fa-caret-down" aria-hidden="true"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-right account-menu-dropdown">
              <li><a href="{{ route('profile.me') }}"><i class="fa fa-user" aria-hidden="true"></i> My Profile</a></li>
              <li>
                <form action="{{ route('logout') }}" method="post">
                  @csrf
                  <button type="submit"><i class="fa fa-sign-out" aria-hidden="true"></i> Log out</button>
                </form>
              </li>
            </ul>
          </li>
        @else
          <li><a href="{{ route('login') }}">Login</a></li>
          <li><a href="{{ route('register') }}">Register</a></li>
        @endauth
      </ul>
    </div>
    <div class="clearfix"> </div>
  </div>
</div>