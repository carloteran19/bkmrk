<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class BookmarkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Bookmarks/Index', [
            'bookmarks' => Bookmark::with('user:id,name')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'url' => 'required|string|max:2083',
        ]);
        $request->user()->bookmarks()->create($validated);
        return redirect(route('bookmarks.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Bookmark $bookmark)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bookmark $bookmark)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bookmark $bookmark): RedirectResponse
    {
        Gate::authorize('update', $bookmark);
        $validated = $request->validate([
            'url' => 'required|string|max:2083',
        ]);
        $bookmark->update($validated);
        return redirect(route('bookmarks.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy(Bookmark $bookmark): RedirectResponse
     {
         Gate::authorize('delete', $bookmark);
         $bookmark->delete();
         return redirect(route('bookmarks.index'));

     }
}
