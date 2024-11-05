@extends('layouts.app')

@section('content')
    <div class='container'>
        <h2>Create an Announcement</h2>
        <br><br>
        <form method="post" action="/announcements" id="create">
            @csrf
            <br>
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" size="40">
            <br>
            <label for="picture_file">Picture File:</label>
            <input type="text" name="picture_file" id="picture_file" size="60">
            <br>
            <label for="summary">Summary:</label>
            <textarea id="summary" name="summary" rows="4" cols="60">
            </textarea>
            <br>
            <label for="when">When:</label>
            <input type="date" name="when" id="title" size="40" value="yyyy-mm-dd">
            <br>
            <label for="venue_name">Venue:</label>
            <select name="venue_name" id="venue_name">
                @foreach($locations as $location)
                    <option value="{{$location->name}}">{{$location->name}}</option>
                @endforeach
            </select>
            <span class="note">If the venue is new, create it before a new announcement.</span>
            <br>
            <label for="notes">Notes:</label>
            <textarea id="notes" name="notes" rows="6" cols="60">
            </textarea>
            <br><br>
        </form>
        <button type="submit" form='create' class="btn btn-go">Submit</button>

    </div>
    <br>
@endsection
