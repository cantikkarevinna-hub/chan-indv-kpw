@extends('admin.layout')

@section('title', 'Manage Reviews')

@section('content')
  <h1>Manage Reviews</h1>

  <form action="{{ route('admin.reviews.index') }}" method="get" class="form-inline" style="margin:20px 0">
    <div class="form-group">
      <label for="review-rating">Filter by rating</label>
      <select class="form-control" id="review-rating" name="rating">
        <option value="">All ratings</option>
        @for ($rating = 5; $rating >= 1; $rating--)
          <option value="{{ $rating }}" @selected((string) ($filters['rating'] ?? '') === (string) $rating)>
            {{ $rating }} {{ $rating === 1 ? 'star' : 'stars' }}
          </option>
        @endfor
      </select>
    </div>
    <button class="btn btn-primary" type="submit">Apply filter</button>
    @if (! empty($filters['rating']))
      <a class="btn btn-default" href="{{ route('admin.reviews.index') }}">Clear filter</a>
    @endif
  </form>

  <div class="table-responsive">
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>Film</th>
          <th>User</th>
          <th>Rating</th>
          <th>Review</th>
          <th>Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($reviews as $review)
          <tr>
            <td>{{ $review->film?->title ?? 'Deleted film' }}</td>
            <td>{{ $review->user?->name ?? 'Former user' }}</td>
            <td>{{ $review->rating }} / 5</td>
            <td>{{ $review->comment }}</td>
            <td>{{ $review->created_at?->format('Y-m-d H:i') }}</td>
            <td>
              <form action="{{ route('admin.reviews.destroy', array_merge(['kritik' => $review->id], request()->query())) }}" method="post" onsubmit="return confirm('Are you sure you want to delete this review?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm" type="submit">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6">No reviews found for this rating.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $reviews->links() }}
@endsection
