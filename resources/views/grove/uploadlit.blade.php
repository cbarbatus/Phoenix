@extends('layouts.app')

@section('content')

    <div class='container'>
        <h2>Upload Liturgy Files</h2>

        <br><br>

        <!-- Message -->
@if(Session::has('message'))
    <p >{{ Session::get('message') }}</p>
@endif

       <!-- Form for getting file name -->
        <form method='post' action='/grove/litfile' enctype='multipart/form-data' >
            {{ csrf_field() }}
            <input type='hidden' name='litfile' value={{ $litname }}>
            <input type='hidden' name='ritid' value={{ $id }}>
            <label for="file">Liturgy File:</label>
            <input type='file' name='file' >


            <input type='submit' name='submit' value='Upload File'>
        </form>
        <br><br>

</div>
<br>
@endsection
