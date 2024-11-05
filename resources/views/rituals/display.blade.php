@extends('layouts.app')

@section('content')
    <div class='container'>
        <h2>{{ $ritual->year }} {{ $ritual->name }} Ritual </h2>
        <br>
        <form method="get" action="/rituals/{{ $ritual['id'] }}/text" id="text">
        </form>

        @if ( ($slideshow ?? '') != '')
        <form method="get" action="/slideshows/{{ $slideshow['id'] }}/view" id="view">
        </form>
        @endif

        @if ($ritual->liturgy_base !== '')
            <button type="submit" form='text' class="btn btn-go">Text</button>
        @else No liturgy text
        @endif

        @if (($slideshow ?? '') != '')
            <button type="submit" form='view' class="btn btn-go">Photos</button>
        @else
            No slideshow
        @endif

        <style>
            img:hover {
                box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
            }
        </style>

        <br><br>
        @if ($announcement === null)
            <h4> No announcement for this ritual </h4>
        @else
            <h4> Announcement Information: </h4><br>
        <ul>
            @if ($announcement->picture_file == '')
                <li><b>Picture:</b> none</li>
            @else
            <li>Click on the image to open it full size in a new window.<br>
                <a target="_blank" href="/img/{{ $announcement->picture_file }}">
                <img src="/img/{{ $announcement->picture_file}}" alt="Ritual" style="max-height:120px">
                </a>
            </li>
            @endif
            <br><br>
            <li><b>Summary:</b> {!! $announcement->summary !!}</li>
            <br><br>
            <li><b>When:</b> {{ $announcement->when }}</li>
            <br><br>
            <li><b>Where:</b> {{ $venue_title }} </li>
        </ul>

        @endif
    </div>
    <br>

@endsection
