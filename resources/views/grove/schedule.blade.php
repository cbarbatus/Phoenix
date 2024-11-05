@extends('layouts.app')

@section('content')

    <div class='container'>
        <h2>Edit Ritual Schedule</h2>
        <br>
        <form method="post" action="/schedupdt/{{ $element->id }}" id="edit">
            @csrf
            @method('put')
            <label for="item">Text:</label>
            <textarea id="item" name="item" rows="20" cols="60"
                      value="{{ $element->item }}">{{ html_entity_decode($element->item) }}
            </textarea>
            <br><br>
        </form>
        <button type="submit" form='edit' class="btn btn-warning">Submit</button>
        <br>
    </div>
    <br>

@endsection
