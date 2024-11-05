<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|RedirectResponse
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('admin')) {
                $users = User::all()->sortBy('name');

                return view('users.index', compact('users'));
            }
        }
        return redirect('/');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|RedirectResponse
    {
        if (Auth::check()) {
            $user = Auth::user();
            dd('in create');
            if ($user->hasRole('admin'))
                return view('users.create');
        }
        return redirect('/');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = new user();
        $item = request('name');
        $user->name = ($item === null) ? '' : $item;
        $item = request('email');
        $user->email = ($item === null) ? '' : $item;
        $user->password = '';
        $user->save();

        return redirect('/users');
    }

    /**
     * Make user for member.
     */
    public function make(int $id): RedirectResponse
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('admin')) {
                $member = Member::findOrFail($id);
                $user = new user();
                $user->name = $member->first_name . $member->last_name;
                $user->email = $member->email;
                $user->password = '';
                $user->assignRole('member');
                $user->save();
                $member->user_id = $user->id;
                $member->save();

                return redirect('/members');
            }
        }
        return redirect('/');
    }

    /**
     * Make superuser of a member.
     */
    public function superuser(int $id): RedirectResponse
    {
        $member = Member::findOrFail($id);
        $user_id = $member->user_id;
        $user = User::findOrFail($user_id);
        $user->assignRole('admin');
        $user->save();

        return redirect('/members');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View|RedirectResponse
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('admin')) {
                $user = User::findOrFail($id);
                $checks = array();
                $roles = Role::all();

                foreach ($roles as $role) {
                    $name = $role->name;
                    if ($user->hasRole($name))
                        $checks[$name] = 'checked';
                    else
                        $checks[$name] = '';
                }
                return view('users.edit', compact('user', 'roles', 'checks'));
            }
        }
        return redirect('/');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $item = request('name');
        $user->name = ($item === null) ? '' : $item;
        $item = request('email');
        $user->email = ($item === null) ? '' : $item;
        $user->save();
        $roles = request('role');
        $user->syncRoles($roles);

        return redirect('/users')->with('success', 'User was updated');
    }

    /**
     * Before destroy, ask sure.
     */
    public function sure(int $id): View
    {
        return view('/users.sure', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/users')->with('success', 'User was deleted');
    }
}
