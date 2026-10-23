<div class="footer">
  <div class="container">
    <div class="w3ls_footer_grid">
      <div class="col-md-6 w3ls_footer_grid_left">
        <div class="w3ls_footer_grid_left1">
          <h2>Subscribe to us</h2>
          @if (session('subscription_status'))
            <p role="status">{{ session('subscription_status') }}</p>
          @endif
          <div class="w3ls_footer_grid_left1_pos">
            <form action="{{ route('subscriptions.store') }}" method="post">
              @csrf
              <input type="email" name="email" value="{{ old('email') }}" placeholder="Your email..." required="">
              <input type="submit" value="Send">
            </form>
            @error('email')
              <p role="alert">{{ $message }}</p>
            @enderror
          </div>
        </div>
      </div>
      <div class="col-md-6 w3ls_footer_grid_right">
        <a href="{{ route('home') }}"><h2>One<span>Movies</span></h2></a>
      </div>
      <div class="clearfix"> </div>
    </div>
    <div class="col-md-5 w3ls_footer_grid1_left">
      <p>&copy; 2016 One Movies. All rights reserved | Design by <a href="http://w3layouts.com/">W3layouts</a></p>
    </div>
    <div class="col-md-7 w3ls_footer_grid1_right">
      <ul>
        <li>
          <a href="genres.html">Movies</a>
        </li>
        <li>
          <a href="horror.html">Action</a>
        </li>
        <li>
          <a href="genres.html">Adventure</a>
        </li>
        <li>
          <a href="comedy.html">Comedy</a>
        </li>
        <li>
          <a href="faq.html">FAQ</a>
        </li>
        <li>
        </li>
        <li>
        </li>
      </ul>
    </div>
    <div class="clearfix"> </div>
  </div>
</div>