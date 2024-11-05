<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class RoleController extends Controller

{
    /**
     * Display a listing of roles and permissions.
     */
    public function roles(): View|RedirectResponse
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('admin')) {
                $roles = Role::all();
                $permissions = Permission::all();
                return view('roles.index', compact('roles', 'permissions'));
            }
        }
        return redirect('/');
    }

    /*   MAINTAIN RULES  */

    /**
     * Show the form for creating a new role.
     */
    public function create(): View|RedirectResponse
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('admin')) {
                return view('roles.create');
            }
        }
        return redirect('/');
    }


    /**
     * Create the role
     */
    public function store(Request $request): RedirectResponse
    {
        $item = request('name');
        $role = Role::create(['name' => $item]);
        return redirect('/roles');
    }


    /**
     * Delete a role, before destroy, ask sure.
     */
    public function sure(string $name): View
    {
        return view('/roles.sure', ['name' => $name]);
    }

    /**
     * Remove the role.
     */
    public function destroy(string $name): RedirectResponse
    {
        $role = Role::where('name', $name)->firstOrFail();
        $role->delete();

        return redirect('/roles')->with('success', 'Role was deleted');
    }


    /*   MAINTAIN PERMISSIONS  */

    /**
     * Show the form for creating a new permission.
     */
    public function pcreate(): View|RedirectResponse
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('admin')) {
                return view('roles.pcreate');
            }
        }
        return redirect('/');
    }


    /**
     * Create the permission
     */
    public function pstore(Request $request): RedirectResponse
    {
        $item = request('name');
        $permission = Permission::create(['name' => $item]);
        return redirect('/roles');
    }


    /**
     * Delete a permission, before destroy, ask sure.
     */
    public function psure(string $name): View
    {
        return view('/roles.psure', ['name' => $name]);
    }

    /**
     * Remove the permission.
     */
    public function pdestroy(string $name): RedirectResponse
    {
        $permission = Permission::where('name', $name)->firstOrFail();
        $permission->delete();
        return redirect('/roles')->with('success', 'Permission was deleted');
    }



    /*   ASSOCIATE PERMISSIONS WITH ROLES   */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $name): View
    {
        $role = Role::where('name', $name)->firstOrFail();
        $pnames = $role->permissions;
        return view('roles.edit', compact(['role', 'pnames']));
    }


    /**
     * Remove the permission from role.
     */
    public function remove(string $name, string $pname): RedirectResponse
    {
        $role = Role::where('name', $name)->firstOrFail();
        $role->revokePermissionTo($pname);
        $pnames = $role->permissions;
        return redirect('/roles/'.$name.'/edit');

    }


    /**
     * Add permission to role.
     */
    public function add(string $name): View
    {
        $role = Role::where('name', $name)->firstOrFail();
        $permissions = Permission::all();

        return view('roles.add', compact(['role', 'permissions']));
    }

    public function set(Request $request, string $name): RedirectResponse
    {
        $role = Role::where('name', $name)->firstOrFail();
        $permissions = Permission::all();
        $pname = $request->input('permission_name');
        $role->givePermissionTo($pname);
        return redirect('/roles/'.$name.'/edit');
    }


}
