@extends('templates.index')

@push('style')
  <link rel="stylesheet" type="text/css" href="{{ asset('template/list-css/table-style.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('template/list-css/basictable.css') }}" />
  <style>
    .movie-reviews-list {
      display: flex;
      flex-direction: column;
      gap: 16px;
      margin-top: 24px;
    }

    .movie-review {
      display: flex;
      align-items: flex-start;
      gap: 16px;
      margin: 0;
      padding: 18px;
      border: 1px solid #e7e7e7;
      border-radius: 6px;
      background: #fff;
    }

    .movie-review-avatar {
      flex: 0 0 66px;
      width: 66px;
      height: 66px;
      object-fit: cover;
    }

    .movie-review-content {
      flex: 1;
      min-width: 0;
    }

    .movie-review-header {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 12px;
      margin-bottom: 6px;
    }

    .movie-review-name {
      margin: 0;
      color: #252525;
      font-size: 16px;
      font-weight: 400;
    }

    .movie-review-rating {
      color: #ff8d1b;
      font-size: 15px;
      letter-spacing: 2px;
      white-space: nowrap;
    }

    .movie-review-text {
      margin: 0;
      color: #666;
      line-height: 1.6;
      overflow-wrap: anywhere;
    }

    .review-rating-picker {
      margin: 0 0 14px;
      padding: 0;
      border: 0;
    }

    .review-rating-picker legend {
      margin-bottom: 4px;
      color: #333;
      font-size: 14px;
      font-weight: 600;
    }

    .review-rating-stars {
      display: inline-flex;
      flex-direction: row-reverse;
      justify-content: flex-end;
    }

    .review-rating-stars input {
      position: absolute;
      width: 1px;
      height: 1px;
      overflow: hidden;
      clip: rect(0, 0, 0, 0);
      white-space: nowrap;
      clip-path: inset(50%);
    }

    .review-rating-stars label {
      margin: 0 2px;
      color: #bdbdbd;
      cursor: pointer;
      font-size: 24px;
      line-height: 1;
    }

    .review-rating-stars input:checked ~ label,
    .review-rating-stars label:hover,
    .review-rating-stars label:hover ~ label {
      color: #ff8d1b;
    }

    .review-rating-stars input:focus-visible + label {
      outline: 2px solid #333;
      outline-offset: 2px;
    }

    @media (max-width: 480px) {
      .movie-review {
        gap: 12px;
        padding: 14px;
      }

      .movie-review-avatar {
        flex-basis: 44px;
        width: 44px;
        height: 44px;
      }
    }
  </style>
@endpush

@push('scripts')

<script type="text/javascript" src="{{ asset('template/list-js/jquery.basictable.min.js') }}"></script>
 <script type="text/javascript">
    $(document).ready(function() {
      $('#table').basictable();
      $('#table-breakpoint').basictable({
        breakpoint: 768
      });
    });
  </script>
@endpush

@section('content')

<div class="container">
  <br />
  <!-- /w3l-medile-movies-grids -->
    <div class="agileits-single-top">
      <ol class="breadcrumb">
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('movies') }}">Movies</a></li>
        <li class="active">{{ $film->title }}</li>
      </ol>
    </div>
    <div class="single-page-agile-info">
                 <!-- /movie-browse-agile -->
                         <div class="show-top-grids-w3lagile">
      <div class="col-sm-8 single-left">
        <div class="song">
          <div class="single-right-grids">

            <div class="col-md-4 single-right-grid-left">
              <a href="{{ route('movies.show', $film->id) }}"><img src="/{{ $film->poster }}" alt="" /></a>
            </div>
            <div class="col-md-8 single-right-grid-right">
              <div class="song-info">
                <h2>{{ $film->title }}</h2>	
                <p class="author"><a href="#" class="author">{{ $film->year }}</a></p>
                <p class="views">{{ $film->sinopsis }}</p>
              </div>
              <div id="myTabContent" class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="home" aria-labelledby="home-tab">
                  <div class="agile-news-table">
                    <table id="table-breakpoint">
                      <thead>
                        <tr>
                        <th>Cast</th>
                        <th>Role</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($perans as $peran)
                        <tr>
                          <td class="w3-list-info">{{ $peran->cast?->name ?? 'Unknown cast member' }}</td>
                          <td class="w3-list-info">{{ $peran->actor }}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"> </div>
          </div>
        </div>
        <div class="song-grid-right">
          <div class="share">
            <h5>Share this</h5>
            <div class="single-agile-shar-buttons">
            <ul>
              <li>
                <div class="fb-like" data-href="https://www.facebook.com/w3layouts" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="false"></div>
                <script>(function(d, s, id) {
                  var js, fjs = d.getElementsByTagName(s)[0];
                  if (d.getElementById(id)) return;
                  js = d.createElement(s); js.id = id;
                  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.7";
                  fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));</script>
              </li>
              <li>
                <div class="fb-share-button" data-href="https://www.facebook.com/w3layouts" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwww.facebook.com%2Fw3layouts&amp;src=sdkpreparse">Share</a></div>
              </li>
              <li class="news-twitter">
                <a href="https://twitter.com/w3layouts" class="twitter-follow-button" data-show-count="false">Follow @w3layouts</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
              </li>
              <li>
                <a href="https://twitter.com/intent/tweet?screen_name=w3layouts" class="twitter-mention-button" data-show-count="false">Tweet to @w3layouts</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
              </li>
              <li>
                <!-- Place this tag where you want the +1 button to render. -->
                <div class="g-plusone" data-size="medium"></div>

                <!-- Place this tag after the last +1 button tag. -->
                <script type="text/javascript">
                  (function() {
                  var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                  po.src = 'https://apis.google.com/js/platform.js';
                  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                  })();
                </script>
              </li>
            </ul>
          </div>
          </div>
        </div>
        <div class="clearfix"> </div>
        <div class="all-comments">
          <div class="all-comments-info">
            <a href="#reviews">Reviews</a>
            <div class="agile-info-wthree-box">
              @if (session('status'))
                <div class="alert alert-success" role="status">{{ session('status') }}</div>
              @endif
              @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                  <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif
              @auth
                <form action="{{ route('movies.reviews.store', $film) }}" method="post">
                  @csrf
                  <fieldset class="review-rating-picker">
                    <legend>Rating</legend>
                    <div class="review-rating-stars">
                      @for ($rating = 5; $rating >= 1; $rating--)
                        <input id="rating-{{ $rating }}" type="radio" name="rating" value="{{ $rating }}" @checked(old('rating') == $rating) required>
                        <label for="rating-{{ $rating }}" title="{{ $rating }} out of 5 stars" aria-label="{{ $rating }} out of 5 stars">&#9733;</label>
                      @endfor
                    </div>
                  </fieldset>
                  <textarea name="comment" placeholder="Write your review..." maxlength="2000" required>{{ old('comment') }}</textarea>
                  @error('rating')<p class="text-danger">{{ $message }}</p>@enderror
                  @error('comment')<p class="text-danger">{{ $message }}</p>@enderror
                  <input type="submit" value="POST REVIEW">
                  <div class="clearfix"></div>
                </form>
              @else
                <p><a href="{{ route('login') }}">Sign in</a> to post a review.</p>
              @endauth
            </div>
          </div>
          <div class="movie-reviews-list" id="reviews">
            @forelse ($comments as $comment)
              <article class="movie-review">
                <img class="movie-review-avatar" src="{{ asset('template/images/user.jpg') }}" alt="">
                <div class="movie-review-content">
                  <div class="movie-review-header">
                    <h5 class="movie-review-name">{{ $comment->user?->name ?? 'Former user' }}</h5>
                    <span class="movie-review-rating" role="img" aria-label="{{ $comment->rating ?? 0 }} out of 5 stars">
                      @for ($star = 1; $star <= 5; $star++)
                        <i class="fa {{ $star <= ($comment->rating ?? 0) ? 'fa-star' : 'fa-star-o' }}" aria-hidden="true"></i>
                      @endfor
                    </span>
                  </div>
                  <p class="movie-review-text">{{ $comment->comment }}</p>
                </div>
              </article>
            @empty
              <p>No reviews yet. Be the first to share your thoughts.</p>
            @endforelse
            @if ($comments->hasPages())
              <div class="movie-reviews-pagination">
                {{ $comments->fragment('reviews')->links() }}
              </div>
            @endif
          </div>
        </div>
      </div>
      <div class="col-md-4 single-right">
        <h3>Similar Film By Genre</h3>
        @foreach ($filmByGenre as $film)
          <div class="single-grid-right">
            <div class="single-right-grids">
              <div class="col-md-4 single-right-grid-left">
                <a href="{{ route('movies.show', $film->id) }}"><img src="/{{ $film->poster }}" alt="" /></a>
              </div>
              <div class="col-md-8 single-right-grid-right">
                <a href="{{ route('movies.show', $film->id) }}" class="title">{{ $film->title }}</a>
                <p class="author"><a href="#" class="author">{{ $film->year }}</a></p>
                <p class="views" style="text-align: justify; margin-right: 10px">{{ $film->sinopsis }}</p>
              </div>
              <div class="clearfix"> </div>
            </div>
          </div>
        @endforeach
      </div>
      <div class="clearfix"> </div>
    </div>
      <!-- //movie-browse-agile -->
      <!--body wrapper start-->
    <div class="w3_agile_banner_bottom_grid">
      <div id="owl-demo" class="owl-carousel owl-theme">
        @foreach ($filmByRelease as $filmRelease)
          <div class="item">
            <div class="w3l-movie-gride-agile w3l-movie-gride-agile1">
              <a href="{{ route('movies.show', $filmRelease->id) }}" class="hvr-shutter-out-horizontal"><img src="/{{ $filmRelease->poster }}" title="{{ $filmRelease->title }}" class="img-responsive" alt=" " />
                <div class="w3l-action-icon"><i class="fa fa-play-circle" aria-hidden="true"></i></div>
              </a>
              <div class="mid-1 agileits_w3layouts_mid_1_home">
                <div class="w3l-movie-text">
                  <h6><a href="{{ route('movies.show', $filmRelease->id) }}">{{ $filmRelease->title }}</a></h6>							
                </div>
                <div class="mid-2 agile_mid_2_home">
                  <p>{{ $filmRelease->year }}</p>
                  <div class="block-stars">
                    <ul class="w3l-ratings">
                      <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                      <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                      <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                      <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                      <li><a href="#"><i class="fa fa-star-half-o" aria-hidden="true"></i></a></li>
                    </ul>
                  </div>
                  <div class="clearfix"></div>
                </div>
              </div>
              @if ($filmRelease->year == now()->year)
                <div class="ribben">
                  <p>NEW</p>
                </div>
              @endif
            </div>
          </div>
        @endforeach
      </div>
    </div>
  <!--body wrapper end-->
          
             
      </div>
      <!-- //w3l-latest-movies-grids -->
    </div>	
  </div>
@endsection

@push('scripts')
<script src="js/simplePlayer.js"></script>
<script>
	$("document").ready(function() {
		$("#video").simplePlayer();
	});
</script>
@endpush