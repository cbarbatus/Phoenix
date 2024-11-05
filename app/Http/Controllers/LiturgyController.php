<?php

namespace App\Http\Controllers;

use App\Models\Ritual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Storage;

class LiturgyController extends Controller
{    /**
     * Narrow selection of liturgies.
     */
    public function find(): View
    {
        if (Auth::check()) return view('/liturgy.find');
        else return redirect('/');
    }


    /**
     * List the selected rituals.
     */
    public function list(Request $request): View
    {
        if (Auth::check()) {

            $name = request('name');
            if ($name == '0') {
                $name = '%';
            }
            $culture = request('culture');
            if ($culture == '0') {
                $culture = '%';
            }
            $rituals = Ritual::orderBy('year', 'DESC')
                ->where('culture', 'LIKE', $culture)
                ->where('name', 'LIKE', $name, 'and')
                ->get();

            return view('liturgy.list', compact('rituals'));
        }
        return redirect('/');
    }


    /**
     * Download the .docx for the ritual.
     *
     * @return \Illuminate\Http\Response
     */
    public function get(int $id)
    {
        if (Auth::check()) {
            $ritual = Ritual::findOrFail($id);

            $fileName = $ritual->liturgy_base . '.docx';
            $location = storage_path('app/grove');
            $fullName = $location . '/' . $fileName;

            return response()->file($fullName);
        }
        return redirect('/');
    }

}
