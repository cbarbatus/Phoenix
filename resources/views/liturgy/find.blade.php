@extends('layouts.app')

@section('content')
    <div class='container'>

        <h2>Full Rituals</h2>

        Select a ritual name or a culture or both to list rituals.  You can then either look at a ritual or download the .docx file.

        <form method="post" action="/liturgy/list" id="create">
            @csrf
            <br>
            <label for="name">Name:</label>
            <select name="name" id="name">
                <option value="0" selected></option>
                <?php $rituals=Config::get('constants.rituals');
                foreach($rituals as $item){
                ?>
                <option value="{{ $item }}" >
                    <?php echo $item; ?>
                </option>
                <?php
                }
                ?>
            </select>
            <br>

            <label for="culture">Culture:</label>
            <select name="culture" id="culture">
                <option value="0" selected></option>
                <?php $cultures=Config::get('constants.cultures');
                foreach($cultures as $item){
                ?>
                <option value="{{ $item }}" >
                    <?php echo $item; ?>
                </option>
                <?php
                }
                ?>
            </select>
            <br>
        </form>
        <button type="submit" form='create' class="btn btn-go">Submit</button>
    </div>
    <br>

@endsection
