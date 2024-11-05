@extends('layouts.app')

@section('content')
    <div class='container'>

        <h2>Delete User: Are you sure?</h2>
        <br><br>
        <form method="get" action="/users/{{ $id }}/destroy" id="sure">
        </form>
            <button type="submit" form="sure" class="btn btn-danger">Confirm Delete</button>
    </div>
    <br>
@endsection
