<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Element;
use App\Models\Member;
use App\Models\Ritual;
use App\Models\User;
use Config;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;
use Session;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class GroveController extends Controller
{
    public function bylaws(): BinaryFileResponse|RedirectResponse
    {
        if (Auth::check()) {
            $fileName = 'bylaws.pdf';
            $location = storage_path('app/grove');
            $fullName = $location.'/'.$fileName;

            return response()->file($fullName);
        }

        return redirect('/');
    }

    public function pay(): View|RedirectResponse
    {
        if (Auth::check()) {
            return view('grove.pay');
        }

        return redirect('/');

    }

    public function contact(): View|RedirectResponse
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('admin')) {
                return view('grove.contact');
            }
        }

        return redirect('/');
    }

    public function contactus(): View
    {
        return view('grove.contactus');
    }

    public function thanks(): View
    {
        return view('grove.thanks');
    }

    public function schedule(): View|RedirectResponse
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole(['admin', 'SeniorDruid'])) {
                /* get id of "Schedule" element */
                $element = Element::where('name', '=', 'Schedule')
                    ->first();

                return view('grove.schedule', ['element' => $element]);
            }
        }

        return redirect('/');
    }

    public function schedupdt($id): RedirectResponse
    {
        $element = Element::find($id);
        $item = request('item');
        $element->item = ($item === null) ? '' : $item;
        $element->save();

        return redirect('/');
    }

    public function upload(): View|RedirectResponse
    {

        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('admin')) {
                return view('grove.upload');
            }
        }

        return redirect('/');

    }

    public function uploadlit($id): View|RedirectResponse
    {
        $ritual = Ritual::findOrFail($id);
        $litname = $ritual->year.'_'.$ritual->name.'.htm';
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole(['admin', 'SeniorDruid'])) {
                $ritual->liturgy_base = $litname;
                $ritual->save();
            }

            return view('grove.uploadlit', compact(['litname', 'id']));
        }

        return redirect('/');

    }

    /* upload announcement picture file */
    public function uploadpic($id): View|RedirectResponse
    {
        $announcement = Announcement::findOrFail($id);
        $picname = $announcement->year.'_'.$announcement->name.'.jpg';

        $announcement->picture_file = $picname;
        $announcement->save();

        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole(['admin', 'SeniorDruid'])) {
                return view('grove.uploadpic', compact('picname'));
            }
        }

        return redirect('/');

    }

    public function uploadFile(Request $request): RedirectResponse
    {
        $file = $request->file('file');
        if (is_null($file)) {
            Session::flash('warning', 'No File Selected.');

            return redirect('grove/upload');
        }
        // File Details
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $tempPath = $file->getRealPath();
        $fileSize = $file->getSize();
        $mimeType = $file->getMimeType();

        // Valid File Extensions
        if ($request->visibility == 'liturgy') {
            $valid_extension = ['htm'];
        } elseif ($request->visibility == 'images') {
            $valid_extension = ['jpg'];
        } else {
            $valid_extension = ['pdf', 'docx'];
        }

        // 2MB in Bytes
        $maxFileSize = 2097152;

        // Check file extension
        if (in_array(strtolower($extension), $valid_extension)) {
            // Check file size
            if ($fileSize <= $maxFileSize) {
                // File upload location
                if ($request->visibility == 'public') {
                    $location = 'contents';
                } elseif ($request->visibility == 'liturgy') {
                    $location = 'liturgy';
                } elseif ($request->visibility == 'images') {
                    $location = 'img';
                } else {
                    $location = storage_path('app/grove');
                }

                // Upload file
                $file->move($location, $filename);

                if ($location == 'liturgy') {
                    $shortname = substr($filename, 0, strlen($filename) - 4);
                    rename(public_path('/liturgy/'.$filename), public_path('/liturgy/'.$shortname));
                }

                Session::flash('message', 'Upload Successful.');
            } else {
                Session::flash('warning', 'File too large. File must be less than 2MB.');
            }
        } else {
            Session::flash('warning', 'Invalid File Extension.');
        }

        // Redirect to index
        return redirect('grove/upload');
    }

    public function litfile(Request $request): RedirectResponse
    {
        $id = $request->ritid;
        $file = $request->file('file');
        if (is_null($file)) {
            Session::flash('warning', 'No File Selected.');

            return redirect("/rituals/$id");
        }

        // File Details
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $fileSize = $file->getSize();
        $litfile = $request->litfile;

        // 2MB in Bytes
        $maxFileSize = 2097152;

        // Check file extension
        if ($extension == 'htm') {
            // Check file size
            if ($fileSize <= $maxFileSize) {

                // Upload file
                $file->move('liturgy', $filename);
                rename(public_path('/liturgy/'.$filename), public_path('/liturgy/'.$litfile));
                Session::flash('message', 'Upload Successful.');

            } else {
                Session::flash('warning', 'File too large. File must be less than 2MB.');
            }
        } else {
            Session::flash('warning', 'Invalid File Extension.');
        }

        // Redirect to index
        return redirect("/rituals/$id");
    }

    public function picfile(Request $request): RedirectResponse
    {
        $file = $request->file('file');
        if (is_null($file)) {
            Session::flash('warning', 'No File Selected.');

            return redirect('/announcements');
        }

        // File Details
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $fileSize = $file->getSize();
        $picfile = $request->picfile;

        // 2MB in Bytes
        $maxFileSize = 2097152;

        // Check file extension
        if ($extension == 'jpg') {
            // Check file size
            if ($fileSize <= $maxFileSize) {

                // Upload file
                $file->move('img', $filename);
                rename(public_path('/img/'.$filename), public_path('/img/'.$picfile));
                Session::flash('message', 'Upload Successful.');

            } else {
                Session::flash('warning', 'File too large. File must be less than 2MB.');
            }
        } else {
            Session::flash('warning', 'Invalid File Extension.');
        }

        // Redirect to index
        return redirect('/announcements');
    }

    /* public allowed to donate */
    public function donate(): View
    {
        return view('grove.donate');
    }

    /* ************************************************************** */

    /* hacks for specific internal testing or setup */

    /**
     * Setup user roles and permissions.
     */
    public function setup()
    {
        $roles = Role::count();
        if ($roles == 0) {
            $role = Role::create(['name' => 'member']);
        }
        if ($roles == 1) {
            $role = Role::create(['name' => 'admin']);
        }

        $permissions = Permission::all();
        $users = Auth::user();

        $members = Member::whereIn('category', ['Elder', 'Member', 'Elder*', 'Member*'])
            ->where('status', '=', 'current')
            ->orderBy('first_name')->orderBy('last_name')
            ->get();

        foreach ($members as $member) {
            if ($member->user_id == 0) {
                $user = new user;
                $user->name = $member->first_name.' '.$member->last_name;
                $user->email = $member->email;
                $user->password = '';
                $user->assignRole('member');
                $user->save();
                $member->user_id = $user->id;
                $member->save();
            }
        }

        $mike = Member::find(59);
        $user_id = $mike->user_id;
        $user = User::find($user_id);
        $user->assignRole('admin');
        dd('it is mikie!', $user);

        dd('setup end');
    }

    public function old_hack1(): RedirectResponse
    {
        /**
         * Do some more foolery with things.
         */
        $permission = Permission::create(['name' => 'change all']);
        $permission = Permission::create(['name' => 'see all']);

        $role = Role::findByName('member');
        $role->givePermissionTo('see private');
        $role->givePermissionTo('see personal');
        $role->givePermissionTo('change own');

        $role = Role::findByName('admin');
        $role->givePermissionTo('see private');
        $role->givePermissionTo('see personal');
        $role->givePermissionTo('change any');
        $role->givePermissionTo('change own');
        $role->givePermissionTo('see all');
        $role->givePermissionTo('change all');

        return redirect('/members')->with('success', 'Hack1 completed.');
    }

    public function newer_hack1(): RedirectResponse
    {
        /**
         * Do some more foolery with things.
         */
        $user = Auth::user();
        $isrole = $user->hasRole('admin');

        $ispermitted = [];
        $ispermitted[] = $user->can('see private');
        $ispermitted[] = $user->can('see personal');
        $ispermitted[] = $user->can('see all');

        dd($ispermitted, $isrole, $user->name, $user->id);

        return redirect('/members')->with('success', 'Hack1 completed.');
    }

    public function hack2()
    {
        /**
         * Do some more foolery with things.
         */
        $theFile = $_SERVER['DOCUMENT_ROOT'].'/contents/'.'bylaws 2011-11-10.pdf';
        $fp = @fopen($theFile, 'rb');
        if ($fp) {
            $bylaws = fread($fp, filesize($theFile));
            fclose($fp);
        } else {
            dd($theFile, 'Ritual text missing');
        }

        $encrypted = Crypt::encrypt($bylaws);
        $theCryptFile = $theFile.'Crypt';
        $myfile = fopen($theCryptFile, 'w');
        fwrite($myfile, $encrypted);
        fclose($myfile);

        $fp = @fopen($theCryptFile, 'rb');
        if ($fp) {
            $bylawsCrypt = fread($fp, filesize($theCryptFile));
            fclose($fp);
        } else {
            dd($theFile, 'Encrypted text missing');
        }

        $message = Crypt::decrypt($bylawsCrypt);

        dd('It works!', strlen($bylaws), strlen($encrypted), strlen($message));
    }

    public function hack3(): RedirectResponse
    {
        /**
         * Do some more foolery with things.
         */
        $role = Role::findByName('admin');
        $role->givePermissionTo('change all');

        return redirect('/members')->with('success', 'Hack completed.');
    }

    public function hack()
    {
        $names = Config::get('constants.cultures');
        dd($names);
    }
}
