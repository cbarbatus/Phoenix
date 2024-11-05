<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Motion;
use App\Models\Vote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $user = Auth::user();
        if (is_null($user)) {
            return redirect('/')->with('warning', 'Admin permission is needed.');
        }
        $member = Member::where('user_id', '=', $user->id)->first();
        $data['member_id'] = $member->id;
        $motion = Motion::where('status', '=', 'open')
            ->first();
        if (! is_null($motion)) {
            $data['current'] = $motion;
            $data['motion_id'] = $motion_id = $motion->id;
            $data['member_id'] = $member_id = $motion->member_id;
            $member = Member::where('id', '=', $member_id)
                ->first();
            $data['name'] = $member->first_name.' '.$member->last_name;
            if ($user->can('change any')) {
                $data['create'] = 'yes';
            } else {
                $data['create'] = 'no';
            }

            /**
             * Build table of all votes for this motion
             */
            $members = Member::whereIn('category', ['Member', 'Elder', 'Elder*', 'Member*'])
                ->where('status', '=', 'current')
                ->orderBy('last_name')
                ->get();
            $votes = [];
            foreach ($members as $member) {
                $vote = [];
                $vote['name'] = $member->first_name.' '.$member->last_name;
                $vote['vote'] = Vote::where('motion_id', '=', $motion->id)
                    ->where('member_id', '=', $member->id)
                    ->first();
                if (! is_null($vote['vote'])) {
                    $votes[] = $vote;
                }
            }
            $data['votes'] = $votes;

            return view('votes.index')->withData($data);
        }

        if ($user->can('change any')) {
            $data['create'] = 'yes';
        } else {
            $data['create'] = 'no';
        }

        return view('votes.nomo', compact('data'));
    }

    public function voted(Request $request): RedirectResponse
    {
        $member_id = request('member_id');
        $motion_id = request('motion_id');
        $vote_type = request('vote');

        if ($vote_type == 'close') {
            $motion = Motion::where('id', '=', $motion_id)
                ->first();
            $motion->status = 'closed';
            $motion->save();

            return redirect('/votes')->with('message', 'Voting closed');
        } else {
            $vote = Vote::where('member_id', '=', $member_id)
                ->where('motion_id', '=', $motion_id)
                ->first();
            if (is_null($vote)) {
                $vote = new Vote();
            }
            $vote->member_id = $member_id;
            $vote->motion_id = $motion_id;
            $vote->vote = $vote_type;
            $vote->save();

            return redirect('/votes')->with('message', 'Vote '.$vote_type.' recorded');
        }
    }

    public function admin()
    {
        $user = Auth::user();
        if ($user->can('change any')) {
            $votes = Vote::orderBy('created_at')
                ->get();
            $change_any = $user->can('change any');

            return view('votes.admin', compact('votes', 'change_any', 'user'));
        }

        return redirect('/')->with('warning', 'Admin permission is needed.');

    }

    public function review(): View
    {
        $motions = Motion::where('status', 'closed')->get();

        return view('votes.review', compact('motions'));
    }

    public function look($id): View
    {
        $motion = Motion::find($id);
        $member = Member::find($motion->member_id);
        $name = $member->first_name.' '.$member->last_name;
        $motion->name = $name;

        $members = Member::whereIn('category', ['Member', 'Elder', 'Elder*', 'Member*'])
            ->orderBy('id')
            ->get();
        $votes = [];

        foreach ($members as $member) {
            $voted = Vote::where('motion_id', '=', $motion->id)
                ->where('member_id', '=', $member->id)
                ->first();

            if ($voted) {
                $vote = [];
                $vote['name'] = $member->first_name.' '.$member->last_name;
                $vote['vote'] = $voted->vote;
                $votes[] = $vote;
            }
        }
        $motions = Motion::where('status', 'closed')->get();

        return view('votes.look', compact('motion', 'votes', 'motions'));

    }

    public function reopen($id): RedirectResponse
    {

        $motion = Motion::find($id);
        $motion->status = 'open';
        $motion->save();

        return redirect('/votes')->with('message', 'Motion '.$id.' reopened');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): RedirectResponse
    {
        $motion = new Motion();
        $motion->status = 'open';
        $motion->member_id = request('member_id');
        $motion->item = request('motion');
        $motion->motion_date = date('Y-m-d');
        $motion->save();

        return redirect('/votes')->with('message', 'Motion created');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd('at store');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Vote $vote)
    {
        dd('at show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Vote $vote)
    {
        dd('at edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vote $vote)
    {
        dd('at update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vote $vote)
    {
        dd('at destroy');
    }
}
