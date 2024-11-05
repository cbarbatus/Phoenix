@extends('layouts.app')

@section('content')
    <div class='container'>
        <h2>Create a New Book</h2>
        <br><br>
        <form method="post" action="/books" id="create">
            @csrf
            <label for="name">Category:</label>
            <input type="text" name="category" id="category" size="20"">
            <br>
            <label for="type">Type:</label>
            <input type="text" name="type" id="type" size="20"}">
            <br>
            <label for="title">Title:</label>
            <input type="text" name="title" id="title"  size="40"">
            <br>
            <label for="author">Author:</label>
            <input type="text" name="author" id="author"  size="40"">
            <br>
            <label for="amazon">Amazon Code:</label>
            <input type="text" name="amazon" id="amazon" size="20"">
            <br>
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" cols="60""></textarea>
            <br>
            <label for="member">Member Recommending:</label>
            <input type="text" name="member" id="member" size="30">
            <br><br>
        </form>
        <button type="submit" form='create' class="btn btn-go">Submit</button>
    </div>
    <br>

@endsection
