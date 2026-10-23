@extends('admin.layout')

@section('title', 'Subscribers')

@section('content')
  <h1>Subscribers</h1>
  <p>{{ $subscribers->total() }} subscribed email address(es).</p>

  <div class="table-responsive">
    <table class="table table-striped table-bordered">
      <thead>
        <tr><th>Email</th><th>Subscribed at</th></tr>
      </thead>
      <tbody>
        @forelse ($subscribers as $subscriber)
          <tr>
            <td>{{ $subscriber->email }}</td>
            <td>{{ $subscriber->created_at?->format('Y-m-d H:i') }}</td>
          </tr>
        @empty
          <tr><td colspan="2">No subscribers yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $subscribers->links() }}
@endsection
