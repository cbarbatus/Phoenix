@extends('layouts.app')

@section('content')
    <div class='container'>

        <h2>Delete Ritual ID {{$id }}: Are you sure?</h2>
        <br><br>
        <form method="get" action="/rituals/{{ $id }}/destroy" id="sure">
        </form>
            <button type="submit" form="sure" class="btn btn-danger">Confirm Delete</button>
    </div>
    <br>
@endsection
