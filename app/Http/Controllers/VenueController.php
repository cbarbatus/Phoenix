<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole(['admin', 'SeniorDruid'])) {
                $venues = Venue::all();

                return view('venues.index', compact('venues'));
            }
        }
        return redirect('/');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        if ($user === null) {
            return redirect('/')->with('warning', 'Login is needed.');
        }

        return view('venues.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $venue = new Venue();
        $item = request('name');
        $venue->name = ($item === null) ? '' : $item;
        $item = request('title');
        $venue->title = ($item === null) ? '' : $item;
        $item = request('address');
        $venue->address = ($item === null) ? '' : $item;
        $item = request('map_link');
        $venue->map_link = ($item === null) ? '' : $item;
        $item = request('directions');
        $venue->directions = ($item === null) ? '' : $item;
        $venue->save();

        return redirect('/venues');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $venue = Venue::findOrFail($id);

        return view('venues.show', compact('venue'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $venue = Venue::findOrFail($id);

        return view('venues.edit', compact('venue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Venue  $venue
     */
    public function update(Request $request, $id): RedirectResponse
    {
        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        $venue = Venue::find($id);
        $item = request('name');
        $venue->name = ($item === null) ? '' : $item;
        $item = request('title');
        $venue->title = ($item === null) ? '' : $item;
        $item = request('address');
        $venue->address = ($item === null) ? '' : $item;
        $item = request('map_link');
        $venue->map_link = ($item === null) ? '' : $item;
        $item = request('directions');
        $venue->directions = ($item === null) ? '' : $item;
        $venue->save();
        return redirect('/venues');
    }

    /**
     * Before destroy, ask sure.
     */
    public function sure(int $id): View
    {
        return view('/venues.sure', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $venue = Venue::findOrFail($id);
        $venue->delete();

        return redirect('/venues')->with('success', 'Venue was deleted');
    }
}
