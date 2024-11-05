@extends('layouts.app')

@section('content')
    <div class='container'>
        <h2>Edit a Ritual</h2>
        <br><br>
        <form method="post" action="/rituals/{{ $ritual->id }}" id="edit">
            @csrf
            @method('put')
            <label for="year">Year:</label>
            <input type="text" name="year" id="year" size='4' value="{{ $ritual->year }}">
            <br>

            <label for="name">Name:</label>
            <?php $name=$ritual->name;?>
            <select name="name" id="name">
            <?php $rituals=Config::get('constants.rituals');
            foreach($rituals as $item){
            ?>
                <option value="{{ $item }}" <?php if($ritual->name==$item) echo 'selected'; ?>>
                     <?php echo $item; ?>
                </option>
            <?php } ?>
            </select>
            <br>


            <label for="culture">Culture:</label>
            <?php $culture=$ritual->culture;?>
            <select name="culture" id="culture">
                <?php $cultures=Config::get('constants.cultures');
                foreach($cultures as $item){
                ?>
                <option value="{{ $item }}" <?php if($ritual->culture==$item) echo 'selected'; ?>>
                    <?php echo $item; ?>
                </option>
                    <?php } ?>
            </select>
            <br><br>
        </form>
        <button type='submit' form='edit' class="btn btn-go">Submit</button>
        <br>


    </div>
    <br>
@endsection
