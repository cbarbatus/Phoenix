<?php

namespace App\Http\Controllers;

use App\{Models\Contact, Models\Section};
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $contacts = null;
        if (! is_null($user)) {
            if ($user->can('change all')) {
                $contacts = Contact::where('status', '=', 'received')->first();
            }
        }

        $sections = Section::where(function ($query) {
            $query->where('id', '<>', '0');
        }
        )->orderBy('sequence')->get();

        return view('welcome.index', compact('sections', 'contacts'));

    }
}
