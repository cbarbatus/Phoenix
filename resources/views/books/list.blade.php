@extends('layouts.app')


@section('content')
    <div class='container'>

    <h2>Select Book to Edit</h2>
    <br><br>
        <form method="get" action="/books/create" id="create">
        </form>
        <button type="submit" form='create' class="btn btn-warning">New Book</button>
    <br><br>

    @foreach ($books as $book)
    <li>
        <a href="/books/{{ $book->id }}/edit">{{ $book->title }}</a>
    </li>
    @endforeach

@endsection
