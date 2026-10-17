<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kritik;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'rating' => ['nullable', 'integer', 'between:1,5'],
        ]);

        $reviews = Kritik::with(['user:id,name', 'film:id,title'])
            ->when(
                ! empty($filters['rating']),
                fn ($query) => $query->where('rating', $filters['rating'])
            )
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.reviews.index', compact('reviews', 'filters'));
    }

    public function destroy(Request $request, Kritik $kritik): RedirectResponse
    {
        $kritik->delete();

        return redirect()
            ->route('admin.reviews.index', $request->only('rating'))
            ->with('status', 'Review deleted successfully.');
    }
}
