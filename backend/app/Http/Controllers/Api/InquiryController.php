<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(ContactSubmission::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);
        $inquiry = ContactSubmission::create($validated);
        return response()->json($inquiry, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $inquiry = ContactSubmission::findOrFail($id);
        return response()->json($inquiry);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inquiry = ContactSubmission::findOrFail($id);
        $validated = $request->validate([
            'read' => 'nullable|boolean',
            'archived' => 'nullable|boolean',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'message' => 'nullable|string',
        ]);
        $inquiry->update($validated);
        return response()->json($inquiry);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $inquiry = ContactSubmission::findOrFail($id);
        $inquiry->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
