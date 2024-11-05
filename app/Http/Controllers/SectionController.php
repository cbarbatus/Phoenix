<?php

namespace App\Http\Controllers;

use App\Models\Element;
use App\Models\Section;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|RedirectResponse
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('admin')) {
                $sections = Section::orderBy('sequence')->get();

                return view('sections.index', compact('sections'));
            }
        }
        return redirect('/');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View|RedirectResponse
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('admin')) {
                $section = Section::findOrFail($id);
                $elements = Element::where('section_id', '=', $id)->orderBy('sequence')->get();

                return view('sections.edit', compact('section', 'elements'));
            }
        }
        return redirect('/');
    }



    /**
     * Turn on the showit flag.
     */
    public function on(Request $request, int $id): RedirectResponse
    {
        $sections = \App\Models\Section::orderBy('sequence')->get();
        foreach ($sections as $section) {
            /*
            var_dump("stopped at section.on", $id, $section); exit();
            */

            $section->showit = 0;
            $section->save();
        }
        $thesection = \App\Models\Section::findOrFail($id);
        $thesection->showit = 1;
        $thesection->save();
        /*
        var_dump("stopped at section.on", $id, $thesection); exit();
        */
        return redirect('/');
    }

    /**
     * Turn off the showit flag.
     */
    public function off(Request $request, int $id): RedirectResponse
    {
        $section = \App\Models\Section::findOrFail($id);
        $section->showit = 0;
        $section->save();

        return redirect('/');
    }
}
