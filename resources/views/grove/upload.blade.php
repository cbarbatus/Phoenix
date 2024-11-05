@extends('layouts.app')

@section('content')

    <div class='container'>
        <h2>Upload Files</h2>

        <br><br>

        <!-- Message -->
@if(Session::has('message'))
    <p >{{ Session::get('message') }}</p>
@endif

        <p>Files can be directed to private or public visibility.  There are
        three public directories - /img for images, /liturgy for ritual texts,
        and /contents for general public files.  Images must be .jpg, ritual texts
        must be .htm, and all private files must be .pdf or .docx only.</p>
        Files must be smaller than 2MB.</p>
        <br>

<!-- Form -->
<form method='post' action='/grove/uploadFile' enctype='multipart/form-data' >
    {{ csrf_field() }}
    <input type='file' name='file' >
    <label for="visibility">Type:</label>
    <select name="visibility" id="visibility">
        <option value="grove">Private</option>
        <option value="public">Public</option>
        <option value="liturgy">Liturgy</option>
        <option value="images">jpg Images</option>
    </select>
    <input type='submit' name='submit' value='Upload File'>
</form>

</div>
<br>
@endsection
