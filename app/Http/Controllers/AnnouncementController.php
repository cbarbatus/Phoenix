<?php

namespace App\Http\Controllers;
use App\Models\Announcement;
use App\Models\Venue;
use App\Models\Element;
use App\Models\Section;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|RedirectResponse
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole(['admin', 'SeniorDruid'])) {
                $announcements = Announcement::all();
                return view('announcements.index', compact('announcements'));
            }
        }
        return redirect('/');
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
            if ($user->hasRole(['admin', 'SeniorDruid'])) {
                $locations = Venue::all();
                $rituals = config('constants.rituals');
                return view('announcements.create', compact('locations', 'rituals'));
            }
        }
        return redirect('/');
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $announcement = new Announcement();

        $item = request('year');
        $announcement->year = ($item === null) ? '' : $item;
        $item = request('name');
        $announcement->name = ($item === null) ? '' : $item;
        $item = request('picture_file');
        $announcement->picture_file = ($item === null) ? '' : $item;
        $item = request('summary');
        $announcement->summary = ($item === null) ? '' : $item;
        $item = request('when');
        $announcement->when = ($item === null) ? '' : $item;
        $item = request('venue_name');
        $announcement->venue_name = ($item === null) ? '' : $item;
        $item = request('notes');
        $announcement->notes = ($item === null) ? '' : $item;
        $announcement->save();

        return redirect('/announcements');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): View|RedirectResponse
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole(['admin', 'SeniorDruid'])) {
                $announcement = Announcement::findOrFail($id);
                return view('announcements.show', compact('announcement'));
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
            if ($user->hasRole(['admin', 'SeniorDruid'])) {
                $announcement = Announcement::findOrFail($id);
                $locations = Venue::all();
                $rituals = config('constants.rituals');
                return view('announcements.edit', compact('announcement', 'locations', 'rituals'));
            }
        }
        return redirect('/');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $announcement = Announcement::find($id);
        $item = request('year');
        $announcement->year = ($item === null) ? '' : $item;
        $item = request('name');
        $announcement->name = ($item === null) ? '' : $item;
        $item = request('picture_file');
        $announcement->picture_file = ($item === null) ? '' : $item;
        $item = request('summary');
        $announcement->summary = ($item === null) ? '' : $item;
        $item = request('when');
        $announcement->when = ($item === null) ? '' : $item;
        $item = request('venue_name');
        $announcement->venue_name = ($item === null) ? '' : $item;
        $item = request('notes');
        $announcement->notes = ($item === null) ? '' : $item;
        $announcement->save();

        return redirect('/announcements');
    }

    /**
     * Copy announcement to front page.
     */
    public function activate(int $id): View|RedirectResponse
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole(['admin', 'SeniorDruid'])) {
                $announcement = Announcement::findOrFail($id);
                $cover_pic = "<img src=\"/img/" . $announcement->picture_file . "\" style=\"display:block; margin-left:auto; margin-right:auto; width:100%; height:auto; border:5px groove black;\" >";

                $venue = Venue::where('name', '=', $announcement->venue_name)->first();
                $driving = $venue->directions;
                $map = $venue->map_link;

                $elements = Element::where('section_id', '=', '5')->get();
                foreach ($elements as $element) {
                    $element_name = $element->name;
                    switch ($element_name) {
                        case 'picture':
                            $element->item = $cover_pic;
                            break;
                        case 'summary':
                            $element->item = $announcement->summary;
                            break;
                        case 'when':
                            $when24 = $announcement->when;
                            $whent = substr($when24, 11, 2);
                            if ($whent > 13)
                                $whent -= 12;
                            $whenap = substr($when24, 0, 11) . $whent . "PM";
                            $element->item = "WHEN: " . $whenap;
                            break;
                        case 'where':
                            $element->item = "WHERE: " . $venue->title;
                            break;
                        case 'notes':
                            $element->item = $announcement->notes;
                            break;
                        case 'driving':
                            $element->item = "DRIVING DIRECTIONS: " . $driving;
                            break;
                        case 'map':
                            $element->item = 'Here is a Google Map to the ritual site.  <a href=" ' . $map . ' ">GOOGLE MAP LINK</a>';
                            break;
                    }
                    $element->save();
                }
            }
        }

        return redirect('/');
    }


    /**
     * Before destroy, ask sure.
     */
    public function sure(int $id): View
    {
        return view('/announcements.sure', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {

        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

        return redirect('/announcements/')->with('success', 'Announcement '.$announcement->id.' was deleted');
    }
}
