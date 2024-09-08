<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {

        $subscriptions = Subscription::get();
        return response()->json($subscriptions);

    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'search_pattern' => 'nullable|string',
        ]);

        $subscription = Subscription::create($validated);

        return response()->json([
            'message' => 'Subscription created successfully',
            'data' => $subscription
        ], 201);
    }
}
