<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     * must be a member
     *
     * @return \Illuminate\Http\Response
     */
    public function index(bool $full=null)
    {

        if (Auth::check()) {
            $user = Auth::user();

                $members = Member::whereIn('category', ['Elder', 'Member'])
                ->where('status', '=', 'current')
                ->orderBy('first_name')->orderBy('last_name')
                ->get();

            $change_all = $user->can('change all');
            $change_own = $user->can('change own');
            $change_members = $user->can('change members');

            return view('members.index', compact('members', 'change_all', 'change_own', 'change_members', 'user'));
        }

        return redirect('/');
    }

    public function full()
    {
        $user = Auth::user();
        $members = Member::get()->sortDesc();
        $change_all = $user->can('change all');
        $change_own = $user->can('change own');
        $change_members = $user->can('change members');
        return view('members.index', compact('members', 'change_all', 'change_own', 'change_members', 'user'));
    }

        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function join()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('joiner'))
                return view('members.join');
        }
        return redirect('/');
    }



    /**
     * Store a newly created resource in storage.
     */
    public function savejoin(Request $request): RedirectResponse
    {

        /**
         * Store a newly created resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         */
        if (Auth::check()) {
            $user = Auth::user();
            $member = new member();
            $item = request('first_name');
            $first_name = ($member->first_name = ($item === null) ? '' : '_'.$item);
            $item = request('last_name');
            $last_name = ($member->last_name = ($item === null) ? '' : $item);
            $item = request('rel_name');
            $member->mid_name = '';
            $member->rel_name = ($item === null) ? '' : $item;
            $member->status = 'Current';
            $member->category = 'Member';
            $item = request('address');
            $member->address = ($item === null) ? '' : $item;
            $item = request('pri_phone');
            $member->pri_phone = ($item === null) ? '' : $item;
            $item = request('alt_phone');
            $member->alt_phone = ($item === null) ? '' : $item;
            $item = request('email');
            $email = ($member->email = ($item === null) ? '' : $item);
            $item = request('joined');
            $member->joined = ($item === null) ? '' : $item;
            $item = request('adf');
            $member->adf = ($item === null) ? '' : $item;
            $user = new user();
            $user->name = $first_name . ' ' . $last_name;
            $user->email = $email;
            $user->password = '';
            $user->save();
            $user->assignRole('pending');
            $user->save();

            $member->user_id = $user->id;
            $member->save();
        }
        return redirect('/')->with('message', '  Join form accepted.');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole(['admin', 'scribe']))
                return view('members.create');
        }
        return redirect('/');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        /**
         * Store a newly created resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         */
        if (Auth::check()) {
            $user = Auth::user();
            $member = new member();
            $item = request('first_name');
            $first_name = ($member->first_name = ($item === null) ? '' : $item);
            $item = request('last_name');
            $last_name = ($member->last_name = ($item === null) ? '' : $item);
            $item = request('mid_name');
            $member->mid_name = ($item === null) ? '' : $item;
            $item = request('rel_name');
            $member->rel_name = ($item === null) ? '' : $item;
            $item = request('status');
            $member->status = ($item === null) ? '' : $item;
            $item = request('category');
            $member->category = ($item === null) ? '' : $item;
            $item = request('address');
            $member->address = ($item === null) ? '' : $item;
            $item = request('pri_phone');
            $member->pri_phone = ($item === null) ? '' : $item;
            $item = request('alt_phone');
            $member->alt_phone = ($item === null) ? '' : $item;
            $item = request('email');
            $email = ($member->email = ($item === null) ? '' : $item);
            $item = request('joined');
            $member->joined = ($item === null) ? '' : $item;
            $item = request('adf');
            $member->adf = ($item === null) ? '' : $item;
            $user = new user();
            $user->name = $first_name . ' ' . $last_name;
            $user->email = $email;
            $user->password = '';
            $user->save();
            $user->assignRole('member');
            $user->save();

            $member->user_id = $user->id;
            $member->save();
        }
            return redirect('/members');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        if (Auth::check()) {
            $user = Auth::user();
            $member = Member::findOrFail($id);
            $change_members = $user->can('change members');
        }
        return view('members.edit', compact('member', 'change_members'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        if (Auth::check()) {
            $user = Auth::user();
            $member = Member::findOrFail($id);
            $item = request('first_name');
            $member->first_name = ($item === null) ? '' : $item;
            $item = request('last_name');
            $member->last_name = ($item === null) ? '' : $item;
            $item = request('mid_name');
            $member->mid_name = ($item === null) ? '' : $item;
            $item = request('rel_name');
            $member->rel_name = ($item === null) ? '' : $item;
            $item = request('status');
            $member->status = ($item === null) ? '' : $item;
            $item = request('category');
            $member->category = ($item === null) ? '' : $item;
            $item = request('address');
            $member->address = ($item === null) ? '' : $item;
            $item = request('pri_phone');
            $member->pri_phone = ($item === null) ? '' : $item;
            $item = request('alt_phone');
            $member->alt_phone = ($item === null) ? '' : $item;
            $item = request('email');
            $member->email = ($item === null) ? '' : $item;
            $item = request('joined');
            $member->joined = ($item === null) ? '' : $item;
            $item = request('adf');
            $member->adf = ($item === null) ? '' : $item;
            $member->save();
            $user = User::find($member->user_id);
            if ($user !== null) {
                $user->email = $member->email;
                $user->name = $member->first_name . " " . $member->last_name;
                $user->save();
                $status = $member->status;
                if ($status != 'Current') {
                    $user->delete();
                    return redirect('/members')->with('success', 'Member was updated, User was removed');
                }
            }
        }
        return redirect('/members')->with('success', 'Member was updated');
    }

    /**
     * Before destroy, ask sure.
     *
     * @return \Illuminate\Http\Response
     */
    public function sure(int $id): view|RedirectResponse
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole(['admin', 'scribe'])) {
                $member = Member::findOrFail($id);
                $name = $member->first_name . ' ' . $member->last_name;
                return view('/members.sure', ['id' => $id, 'name'=> $name]);
            }
        }
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole(['admin', 'scribe'])) {
                $member = Member::findOrFail($id);
                $user = User::findOrFail($member->user_id);
                $user->delete();
                $member->delete();
            }
            return redirect('/members')->with('success', 'Member was deleted');
        }

        return redirect('/');
    }


    /**
     * Restore a Resigned member
     *
     *
     */

    public function restore(Request $request)
    {
        $user = Auth::user();
        if ($user->can('change members')) {

            $first_name = request('first_name');
            $last_name = request('last_name');

            $member = Member::whereIn('category', ['Elder', 'Member'])
                ->where('status', '=', 'Resigned')
                ->where('first_name', '=', $first_name)
                ->where('last_name', '=', $last_name)
                ->first();


            if ($member !== null) {

                $member->status = 'Current';
                $member->save();

                $user = new user();
                $user->name = $first_name . ' ' . $last_name;
                $user->email = $member->email;
                $user->password = '';
                $user->assignRole('member');
                $user->save();

                $member->user_id = $user->id;
                $member->save();

            }
            return redirect('/members');
        }

        return redirect('/');
    }

}
