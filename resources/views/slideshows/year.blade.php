@extends('layouts.app')

@section('content')
    <div class='container'>

        <h2>Slideshow Events for {{ $year }}</h2>
        <br><br>
        <ul>
            @foreach ($slideshows as $slideshow)
            <li>
                @if ($admin)
                    <a href="/slideshows/{{ $slideshow->id }}/edit"> {{ $slideshow->name }} </a>
                @else
                    <a href="/slideshows/{{ $slideshow->id }}/view"> {{ $slideshow->name }} </a>
                @endif
            </li>
            @endforeach
        </ul>
    </div>
    <br>
@endsection
