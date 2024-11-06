<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $cats = DB::table('books')
            ->select('category')
            ->distinct()
            ->groupBy('category')
            ->get();
        $activeCats = [];
        foreach ($cats as $cat) {
            $activeCats[] = $cat->category;
        }

        return view('books.index', compact('activeCats'));
    }

    /**
     * Display a listing of one categpru if not admin.
     */
    public function cat(string $cat): View
    {
        $books = DB::table('books')
            ->select()
            ->where('category', '=', $cat)
            ->orderBy('type')
            ->orderBy('title')
            ->get();

        return view('books.cat', compact('books', 'cat'));
    }

    /**
     * Display a listing of the resource.
     */
    public function list(): View
    {
        $books = Book::orderBy('title')
            ->get();

        return view('books.list', compact('books'));
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

        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        $book = new book;
        $item = request('type');
        $book->type = ($item === null) ? '' : $item;
        $item = request('category');
        $book->category = ($item === null) ? '' : $item;
        $item = request('title');
        $book->title = ($item === null) ? '' : $item;
        $item = request('author');
        $book->author = ($item === null) ? '' : $item;
        $item = request('amazon');
        $book->amazon = ($item === null) ? '' : $item;
        $item = request('description');
        $book->description = ($item === null) ? '' : $item;
        $item = request('member');
        $book->member = ($item === null) ? '' : $item;
        $book->save();

        return redirect('/books/list');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        dd('in books/show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $book = Book::findOrFail($id);

        return view('books.edit', compact('book'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $book = Book::find($id);
        $item = request('title');
        $book->title = ($item === null) ? '' : $item;
        $item = request('category');
        $book->category = ($item === null) ? '' : $item;
        $item = request('type');
        $book->type = ($item === null) ? '' : $item;
        $item = request('amazon');
        $book->amazon = ($item === null) ? '' : $item;
        $item = request('description');
        $book->description = ($item === null) ? '' : $item;
        $item = request('member');
        $book->member = ($item === null) ? '' : $item;
        $book->save();

        return redirect('/books/list')->with('success', 'Book was updated');
    }

    /**
     * Before destroy, ask sure.
     */
    public function sure(int $id): View
    {
        return view('/books.sure', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect('/books/list')->with('success', 'Book was deleted');
    }
}
