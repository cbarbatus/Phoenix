@extends('layouts.app')

@section('content')
    <div class='container'>
        <h2>Create Roles</h2>
        <br><br>
        <form method="post" action="/roles/store" id="create">
            @csrf
            <label for="name">Name:</label>
            <input type="text" name="name" id="name">
            <br><br>
        </form>
        <button type="submit" form='create' class="btn btn-go">Submit</button>

    </div>
@endsection
