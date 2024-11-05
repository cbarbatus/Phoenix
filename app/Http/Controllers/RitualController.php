<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Ritual;
use App\Models\Slideshow;
use App\Models\Venue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RitualController extends Controller
{
    /**
     * Display a listing of the resource if not admin.
     */
    public function list(bool $admin): View|RedirectResponse
    {
            $rituals = Ritual::all();
            $years = DB::table('rituals')
                ->select('year')
                ->groupBy('year')
                ->orderby('year', 'DESC')
                ->get()->toArray();
            $activeYears = [];
            foreach ($years as $year) {
                $activeYears[] = $year->year;
            }

        return view('rituals.index', compact('rituals', 'activeYears', 'admin'));
   }

    /**
     * Display a listing of one year if not admin.
     */
    public function year(string $year, bool $admin): View
    {
        $rituals = DB::table('rituals')
            ->select()
            ->where('year', '=', $year)
            ->get();

        return view('rituals.year', compact('rituals', 'year', 'admin'));
    }

    /**
     * Find one ritual from year and name
     *
     * @return \Illuminate\Http\Response
     */
    public function one(Request $request)
    {
        $year = request('year');
        $name = request('name');
        $admin = request('admin');

        $id = DB::table('rituals')
            ->select()
            ->where([['year', '=', $year],
                ['name', '=', $name]])
            ->value('id');
        $ritual = Ritual::find($id);
        if (is_null($ritual)) {
            return redirect('/rituals/0/list')->with('message', 'Ritual not defined');
        }

        $announcement = Announcement::where('year', '=', $year)
            ->where('name', '=', $name)
            ->first();
        if ($admin) {
            $locations = Venue::all();
            return view('rituals.edit', compact('ritual', 'locations'));
        }

        $sid = DB::table('slideshows')
            ->select()
            ->where([['year', '=', $ritual->year],
                ['name', '=', $ritual->name]])
            ->value('id');
        $slideshow = Slideshow::find($sid);

        return view('rituals.display', compact('ritual', 'announcement'));
    }

    /**
     * Display one ritual.
     */
    public function display($id): View
    {
        $ritual = Ritual::findOrFail($id);

        $sid = DB::table('slideshows')
            ->select()
            ->where([['year', '=', $ritual->year],
                ['name', '=', $ritual->name]])
            ->value('id');
        $slideshow = Slideshow::find($sid);

        $announcement = Announcement::where('year', '=', $ritual->year)
            ->where('name', '=', $ritual->name)
            ->first();
        $venue_title = '';
        if ($announcement !== null) {
            $venue = Venue::where('name', '=', $announcement->venue_name)->first();
            $venue_title = $venue->title;
        }
        return view('rituals.display', compact('ritual', 'slideshow', 'announcement', 'venue_title'));
    }

    /**
     * Show the liturgy text for ritual.
     *
     * @return \Illuminate\Http\Response
     */
    public function text(int $id)
    {
        $rite = Ritual::findOrFail($id);
        $liturgy = $rite->liturgy_base;
        $theFile = $_SERVER['DOCUMENT_ROOT'].'/liturgy/'.$liturgy;
        $fp = @fopen($theFile, 'rb');
        if ($fp) {
            $text = fread($fp, filesize($theFile));
            fclose($fp);
        } else {
            $theFile = $theFile.'.htm';
            $fp = @fopen($theFile, 'rb');
            if ($fp) {
                $text = fread($fp, filesize($theFile));
                fclose($fp);
            } else {
                return redirect('/rituals/0/list')->with('message', 'Ritual text missing');
            }
        }
        // Parse the HTML file into array of lines $contents
        $charset = strpos($text, 'charset=');
        $endset = strpos(substr($text, $charset), '"') + $charset;
        $start = $charset + 8;
        $size = $endset - $start;
        $type = strtolower(substr($text, $start, $size));
        if (substr($type, 0, 3) != 'utf') {
            $utftext = substr_replace($text, 'utf-8          ', $charset + 8, $size);
            $utftext = utf8_encode($utftext);
        } else {
            $utftext = $text;
        }
        $contents = preg_split("/\r?\n|\r/", $utftext);
        $count = count($contents);
        for ($i = 0; $i < $count; $i++) {
            if (strtolower(substr($contents[$i], 0, 5)) == '<body') {
                break;
            }
        }
        for ($l = $i + 1; $l < $count; $l++) {
            if (strtolower(substr($contents[$l], 0, 4)) == '</bo') {
                break;
            }
        }
        $parms = [$i + 1, $l, $contents];

        return view('rituals.text', compact('parms'));
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

        $rituals = config('constants.rituals');
        $venues = Venue::all();
        $venue_names = [];
        foreach($venues as $venue)
            $venue_names[] = $venue->name;
        $cultures = config('constants.cultures');
        return view('rituals.create', compact('venue_names', 'rituals', 'cultures'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {


        $ritual = new Ritual();
        $item = request('year');
        $ritual->year = ($item === null) ? '' : $item;
        $item = request('name');
        $ritual->name = ($item === null) ? '' : $item;
        $item = $ritual->year . "_" . $ritual->name;
        $ritual->liturgy_base = ($item === null) ? '' : $item;
        $item = request('culture');
        $ritual->culture = ($item === null) ? '' : $item;

        /* check that ritual year and name are not duplicated */
        $previous = Ritual::where('year', '=', $ritual->year)
            ->where('name', '=', $ritual->name)
            ->first();
        if ($previous !== null) {
            return back()->with('error', 'Ritual year and name already used! ');
 /*           return redirect('/rituals/create'); */
        }

        /* check that announcement exists */



        $ritual->save();

        return redirect('/rituals/1/list');

    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): View
    {
        $ritual = Ritual::findOrFail($id);

        return view('rituals.show', compact('ritual'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $ritual = Ritual::findOrFail($id);
        $locations = Venue::all();

        return view('rituals.edit', compact('ritual', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $ritual = Ritual::find($id);
        $item = request('year');
        $ritual->year = ($item === null) ? '' : $item;
        $item = request('name');
        $ritual->name = ($item === null) ? '' : $item;
        $item = request('liturgy_base');
        $ritual->liturgy_base = ($item === null) ? '' : $item;
        $item = request('culture');
        $ritual->culture = ($item === null) ? '' : $item;
        $ritual->save();

        return redirect('/rituals/'.$ritual->id);
    }

    /**
     * Before destroy, ask sure.
     */
    public function sure(int $id): View
    {
        return view('/rituals.sure', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $ritual = Ritual::findOrFail($id);
        $ritual->delete();

        return redirect('/rituals/1/list')->with('success', 'Ritual was deleted');
    }
}
