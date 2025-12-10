<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Donation::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:255',
            'mode_of_payment' => 'nullable|string|max:255',
            'reference_number' => 'nullable|string|max:255',
            'donation_amount' => 'nullable|numeric',
            'proof_of_payment_base64' => 'required|string',
        ]);
        $validated['status'] = $validated['status'] ?? 'pending';
        if ($request->user()) { $validated['user_id'] = $request->user()->id; }
        $donation = Donation::create($validated);
        return response()->json($donation, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $donation = Donation::findOrFail($id);
        return response()->json($donation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $donation = Donation::findOrFail($id);
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'contact_number' => 'nullable|string|max:255',
            'mode_of_payment' => 'nullable|string|max:255',
            'reference_number' => 'nullable|string|max:255',
            'donation_amount' => 'nullable|numeric',
            'status' => 'nullable|string|in:pending,verified,completed',
            'proof_of_payment_base64' => 'nullable|string',
        ]);
        $donation->update($validated);
        return response()->json($donation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $donation = Donation::findOrFail($id);
        $donation->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
