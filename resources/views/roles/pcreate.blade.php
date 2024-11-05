@extends('layouts.app')

@section('content')
    <div class='container'>
        <h2>Create Permissions</h2>
        <br><br>
        <form method="post" action="/roles/pstore" id="pcreate">
            @csrf
            <label for="name">Name:</label>
            <input type="text" name="name" id="name">
            <br><br>
        </form>
        <button type="submit" form='pcreate' class="btn btn-go">Submit</button>

    </div>
@endsection
