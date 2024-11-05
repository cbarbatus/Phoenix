@extends('layouts.app')

@section('content')
    <div class='container'>
        <h2>Edit Text Section {{ $section->id }}</h2>
        <br>
        <form method="post" action="/sections/"{{ $section->id }} id="edit">
            @csrf
            @method('put')
            <br>
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" size="40" value="{{ $section->title }}">
            <br>
            <label for="name">Name:</label>
            <input type="text" name="name" id="namee" size="20" value="{{ $section->name }}">
            <br>
            <label for="sequence">Sequence:</label>
            <input type="number" name="sequence" id="seqence" size="4" value="{{ $section->sequence }}">
            <br><br>
        </form>
        <button type="submit" form='edit' class="btn btn-go">Submit</button>
        <br>
<hr>
        <h3>Elements in Section {{ $section->id }}</h3>

        <br>
        <form method="get" action="/elements/{{ $section->id }}/create" id="create">
        </form>
        <button type="submit" form='create' class="btn btn-warning">New Element</button>
        <br><br>


        <table class="table table-striped">
            <thead>
            <tr style="font-weight:bold">
                <td>ID</td>
                <td>Name</td>
                <td>Title</td>
                <td>Sequence</td>
                <td colspan="2">Action</td>
            </tr>
            </thead>
            <tbody>
            @foreach($elements as $element)
                <tr>
                    <td>{{$element->id}}</td>
                    <td>{{$element->name}}</td>
                    <td>{{$element->title}}</td>
                    <td>{{$element->sequence}}</td>
                    <td><form method="get" action="/elements/{{ $element['id']}}/edit" id="edit">
                            @csrf
                            @method('GET')
                            <button type="submit" class="btn btn-warning" >Edit</button>
                        </form>
                    </td>
                    <td>
                        <form method="get" action="/elements/{{ $element['id']}}/sure" id="sure">
                            @csrf
                            @method('GET')
                            <button type="submit" class="btn btn-danger" >Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
    <br>
@endsection
