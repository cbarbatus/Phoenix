@extends('layouts.app')


@section('content')
    <div class='container'>

    <h2>Select Category</h2>
    <br><br>

    @foreach ($activeCats as $cat)
    <li>
        <a href="/books/{{ $cat }}/cat">{{ $cat }}</a>
    </li>
    @endforeach
    </div>
    <br>
@endsection
