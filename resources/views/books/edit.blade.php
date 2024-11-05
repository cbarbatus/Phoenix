@extends('layouts.app')

@section('content')
    <div class='container'>
        <h2>Edit a Book</h2>
        <br><br>
        <form method="post" action="/books/{{ $book->id }}" id="edit">
            @csrf
            @method('put')
            <label for="title">Title:</label>
            <input type="text" name="title" id="title"  size="80" value="{{ $book->title }}">
            <br>
            <label for="category">Category:</label>
            <input type="text" name="category" id="category" size="20" value="{{ $book->category }}">
            <br>
            <label for="title">Type:</label>
            <input type="text" name="type" id="type" size="20" value="{{ $book->type }}">
            <br>
            <label for="address">Amazon Code:</label>
            <input type="text" name="amazon" id="amazon" size="20" value="{{ $book->amazon }}">
            <br>
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" cols="60" value="{{ $book->description }}">
{{ html_entity_decode($book->description) }}</textarea>
            <br>
            <label for="member">Recommending Member:</label>
            <input type="text" name="member" id="member" size="20" value="{{ $book->member }}">
            <br><br>
        </form>
        <button type="submit" form='edit' class="btn btn-warning">Submit</button>
        <br><br>
        <form method="get" action="/books/{{ $book['id']}}/sure" id="sure">
            @csrf
            @method('GET')
            <button type="submit" class="btn btn-danger" >Delete</button>
        </form>
    </div>
    <br>
@endsection
