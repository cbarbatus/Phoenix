<?php

namespace App\Http\Controllers;

use App\Models\Slideshow;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SlideshowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list(bool $admin): View|RedirectResponse
    {
        $slideshows = Slideshow::all();
        $years = DB::table('slideshows')
            ->select('year')
            ->distinct()
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();
        $activeYears = [];
        foreach ($years as $year)
            $activeYears[] = $year->year;

        $names = DB::table('slideshows')
            ->select('name')
            ->distinct()
            ->groupBy('name')
            ->get();
        $activeNames = [];
        foreach ($names as $name) {
            $activeNames[] = $name->name;
        }
        return view('slideshows.index', compact('slideshows', 'activeYears', 'activeNames', 'admin'));
    }


    /**
     * Find one slideshow from year and name
     */
    public function one(Request $request, bool $admin): RedirectResponse
    {
        $year = request('year');
        $name = request('name');

        $id = DB::table('slideshows')
            ->select()
            ->where([['year', '=', $year],
                ['name', '=', $name]])
            ->value('id');
        $slideshow = Slideshow::find($id);

        if (is_null($slideshow)) {
            return redirect('/slideshows/0/list')->with('message', 'Slideshow not defined');
        }

        if ($admin) {
            $target = 'slideshows/'.$id.'/edit';
        } else {
            $target = 'slideshows/'.$id.'/view';
        }

        return redirect($target);

    }

    /**
     * Display a listing of one year if not admin.
     */
    public function year(string $year, bool $admin): View
    {
        $slideshows = DB::table('slideshows')
            ->select()
            ->where('year', '=', $year)
            ->orderBy('sequence')
            ->get();

        return view('slideshows.year', compact('slideshows', 'year', 'admin'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View|RedirectResponse
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('admin'))
                return view('slideshows.create');
        }
        return redirect('/')->with('warning', 'Login is needed.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $slideshow = new Slideshow();
        $item = request('year');
        $slideshow->year = ($item === null) ? '' : $item;
        $item = request('name');
        $slideshow->name = ($item === null) ? '' : $item;
        $item = request('title');
        $slideshow->title = ($item === null) ? '' : $item;
        $item = request('google_id');
        $slideshow->google_id = ($item === null) ? '' : $item;
        $item = request('sequence');
        $slideshow->sequence = ($item === null) ? '' : $item;
        $slideshow->save();

        return redirect('/slideshows/1/list');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $slideshow = Slideshow::findOrFail($id);

        return view('slideshows.edit', compact('slideshow'));
    }

    /**
     * View a slideshow.
     */
    public function view($id): View
    {
        $slideshow = Slideshow::findOrFail($id);

        return view('slideshows.view', compact('slideshow'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $slideshow = Slideshow::find($id);
        $item = request('year');
        $slideshow->year = ($item === null) ? '' : $item;
        $item = request('name');
        $slideshow->name = ($item === null) ? '' : $item;
        $item = request('title');
        $slideshow->title = ($item === null) ? '' : $item;
        $item = request('title');
        $slideshow->title = ($item === null) ? '' : $item;
        $item = request('google_id');
        $slideshow->google_id = ($item === null) ? '' : $item;
        $item = request('sequence');
        $slideshow->sequence = ($item === null) ? '' : $item;
        $slideshow->save();

        return redirect('/slideshows/1/list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slideshow $slideshow)
    {
        //
    }
}
