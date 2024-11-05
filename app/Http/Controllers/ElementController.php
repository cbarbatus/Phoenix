<?php

namespace App\Http\Controllers;

use App\Models\Element;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ElementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        var_dump('stopped at element.index');
        exit();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(int $section_id)
    {
        $user = auth()->user();
        if ($user === null) {
            return redirect('/')->with('warning', 'Login is needed.');
        }

        return view('elements.create', compact('section_id'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $element = new Element();
        $item = request('section_id');
        $element->section_id = ($item === null) ? '' : $item;
        $item = request('name');
        $element->name = ($item === null) ? '' : $item;
        $item = request('title');
        $element->title = ($item === null) ? '' : $item;
        $item = request('sequence');
        $element->sequence = ($item === null) ? '' : $item;
        $item = request('item');
        $element->item = ($item === null) ? '' : $item;
        $element->save();

        return redirect('/sections/'.$element->section_id.'/edit');

    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        var_dump('stopped at element.show', $id);
        exit();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $element = Element::findOrFail($id);

        return view('elements.edit', compact('element'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $element = Element::find($id);
        $item = request('title');
        $element->title = ($item === null) ? '' : $item;
        $item = request('name');
        $element->name = ($item === null) ? '' : $item;
        $item = request('sequence');
        $element->sequence = ($item === null) ? '' : $item;
        $item = request('item');
        $element->item = ($item === null) ? '' : $item;
        $element->save();
        $section_id = $element->section_id;

        return redirect('/sections/'.$section_id.'/edit');
    }

    /**
     * Before destroy, ask sure.
     */
    public function sure(int $id): View
    {
        return view('/elements.sure', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $element = Element::findOrFail($id);
        $section_id = $element->section_id;
        $element->delete();

        return redirect('/sections/'.$section_id.'/edit')->with('success', 'Element '.$element->id.' was deleted');
    }
}
