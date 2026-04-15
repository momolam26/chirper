<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Import the trait
use Illuminate\Http\Request;

class ChirpController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chirps = Chirp::with('user')
            ->latest()
            ->take(50)
            ->get();

        return view('home', compact('chirps'));
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
    public function store(Request $request)
    {
        //
        $validated = $request->validate(
            [
                'message' => 'required|string|max:255'
            ],
            [
                'message.required' => 'Please write something to chirp!',
                'message.max' => 'Chirps must be 255 characters or less.',

            ]
        );

        //Use the authenticated user when creating the chirps

        auth()->user()->chirps()->create($validated);


        //redirect back to the feed
        return redirect(route('home'))->with('success', 'Chirp created !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {
        $this->authorize('edit', $chirp);
        return view('chirps.edit', compact('chirp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp)
    {
        $this->authorize('update', $chirp);
        $validated = $request->validate(
            [
                'message' => 'required|string|max:255'
            ],
            [
                'message.required' => 'Please write something to chirp!',
                'message.max' => 'Chirps must be 255 characters or less.',

            ]
        );

        $chirp->update($validated);

        return redirect(route('home'))->with('success', 'Chirp updated !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        //
         $this->authorize('delete', $chirp);
        $chirp->destroy($chirp->id);
        return redirect(route('home'))->with('success', 'Chirp deleted !');
    }
}
