@extends('layouts.app')

@section('content')

    <div class='container' style="background: white;">
        <h2>{{ $slideshow->year.' '.$slideshow->name }}</h2>

            <div class='embed-container'>
            <iframe src="https://docs.google.com/presentation/d/e/{{ $slideshow->google_id }}/embed?start=true&loop=true&delayms=5000"
                    frameborder="0" width=1280 height=720 allowfullscreen="true" mozallowfullscreen="true"
                    webkitallowfullscreen="true"></iframe>
            </div>

        <br><br>

@endsection

