<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Models\Chirp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ChirpController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Chirps/Index', [
            'chirps' => Chirp::with('user:id,name')->latest()->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('chirps', 'public');
        }

        $request->user()->chirps()->create($validated);

        return redirect()->route('chirps.index')->with('success', 'Chirp uploaded successfully');
    }

    public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        Gate::authorize('update', $chirp);

        $validated = $request->validate([
            'message' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($chirp->image) {
                Storage::disk('public')->delete($chirp->image);
            }

            $validated['image'] = $request->file('image')->store('chirps', 'public');
        }

        $chirp->update($validated);

        return redirect()->route('chirps.index')->with('success', 'Chirp updated successfully');
    }

    public function destroy(Chirp $chirp): RedirectResponse
    {
        Gate::authorize('delete', $chirp);

        if ($chirp->image) {
            Storage::disk('public')->delete($chirp->image);
        }

        $chirp->delete();

        return redirect()->route('chirps.index')->with('success', 'Chirp deleted successfully');
    }
}
