<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'email' => strtolower(trim((string) $request->input('email'))),
        ]);

        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        $subscriber = Subscriber::firstOrCreate(['email' => $validated['email']]);

        return back()->with(
            'subscription_status',
            $subscriber->wasRecentlyCreated
                ? 'Thank you for subscribing!'
                : 'This email is already subscribed.'
        );
    }
}
