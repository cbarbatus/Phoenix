@extends('layouts.app')

@section('content')
    <div class='container'>
        <h2>Create Users</h2>
        <br><br>
        <form method="post" action="/users" id="create">
            @csrf
            <label for="name">Name:</label>
            <input type="text" name="name" id="name">
            <br>
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" size="40">
            <br><br>
        </form>
        <button type="submit" form='create' class="btn btn-go">Submit</button>

    </div>
    <br>
@endsection
