@extends('layouts.app')

@section('content')

    <div class='container'>
        <h2>Edit Text Element {{ $element->id }}</h2>
        <br>
        <form method="post" action="/elements/{{ $element->id }}" id="edit">
            @csrf
            @method('put')
            <br>
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" size="40" value="{{ $element->title }}">
            <br>
            <label for="name">Name:</label>
            <input type="text" name="name" id="namee" size="20" value="{{ $element->name }}">
            <br>
            <label for="sequence">Sequence:</label>
            <input type="number" name="sequence" id="sequence" size="4" value="{{ $element->sequence }}">
            <br>
            <label for="item">Text:</label>
            <textarea id="item" name="item" rows="4" cols="60"
                      value="{{ $element->item }}">{{ html_entity_decode($element->item) }}
            </textarea>
            <br><br>
        </form>
        <button type="submit" form='edit' class="btn btn-warning">Submit</button>
        <br>
    </div>
    <br>

@endsection
