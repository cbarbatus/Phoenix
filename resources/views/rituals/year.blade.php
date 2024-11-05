@extends('layouts.app')

@section('content')
    <div class='container'>
        <h2>Rituals for {{ $year }}</h2>
        <br><br>
        <ul>
            @foreach ($rituals as $ritual)
            <li>
                @if ($admin)
                    <a href="/rituals/{{ $ritual->id }}"> {{ $ritual->name }} </a>
                @else
                    <a href="/rituals/{{ $ritual->id }}/display"> {{ $ritual->name }} </a>
                @endif
            </li>
            @endforeach
        </ul>
    </div>
    <br>
@endsection
