@extends('layouts.app')

@section('content')
    <div class='container'>

        <h2>Ritual Details</h2>

        <br><b>Title: </b>{{ $announcement['title'] }}

        <br><b>Summary: </b>{{ $announcement['summary'] }}
        <br><b>When: </b>{{ $announcement['when'] }}
        <br><b>Where: </b>{{ $announcement['venue_name'] }}
        <br><b>Notes: </b>{{ htmlentities($announcement['notes']) }}
        <br><br>

        <form method="get" action="/announcements/{{ $announcement['id']}}/edit" id="edit">
        </form>
            <button type="submit" form='edit' class="btn btn-warning">Edit</button>

        <br><b>Picture File: </b>{{ $announcement['picture_file'] }}
        <form method="get" action="/announcements/{{ $announcement['id']}}/uploadpic" id="uppic">
                <button type="submit" form='uppic' class="btn btn-warning">Upload</button>
                <br><br>
        </form>
        <button type="submit" form='edit' class="btn btn-warning">Upload</button>

        <form method="get" action="/announcements/{{ $announcement['id'] }}/sure" id="sure">
        </form>
            <button type="submit" form="sure" class="btn btn-danger">Delete</button>
        <br><br>
        <form method="get" action="/announcements/" id="done">
        </form>
            <button type="submit" form='done' class="btn btn-go">Done</button>


@endsection