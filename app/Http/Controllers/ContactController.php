<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole(['admin', 'SeniorDruid'])) {

                $contacts = Contact::where('status', '=', 'received')
                    ->orderBy('created_at')
                    ->get();

                return view('contacts.index', compact('contacts'));
            }
        }

        return redirect('/');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(string $type)
    {
        $user = Auth::user();

        if ($type == 'all') {
            $contacts = Contact::orderBy('created_at')
                ->get();
        } else {
            $contacts = Contact::where('status', '=', $type)
                ->orderBy('created_at')
                ->get();
        }

        return view('contacts.index', compact('contacts'));

        return redirect('/');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(contact $contact)
    {
        //
    }

    public function contactus(): View
    {
        return view('contacts.contactus');
    }

    public function submit(Request $request): RedirectResponse
    {
        $contact = new Contact();
        $item = request('name');
        $contact->name = ($item === null) ? '' : $item;
        $item = request('email');
        $contact->email = ($item === null) ? '' : $item;
        $item = request('message');
        $contact->message = ($item === null) ? '' : $item;
        $contact->status = 'received';
        $contact->when_replied = '1970-01-09 00:00';
        $contact->save();

        return redirect('/contacts/thanks');
    }

    public function thanks(): View
    {
        return view('contacts.thanks');
    }

    public function spam($id): RedirectResponse
    {
        $contact = Contact::findOrFail($id);
        $contact->status = 'spam';
        $contact->save();

        return redirect('/contacts');
    }

    public function reply($id): RedirectResponse
    {
        $contact = Contact::findOrFail($id);
        $contact->status = 'replied';
        $contact->when_replied = date('Y-m-d H:i:s');
        $contact->save();

        return redirect('/contacts');

        return redirect('/contacts');
    }
}
