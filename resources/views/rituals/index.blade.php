@extends('layouts.app')

@section('content')

    <div class='container'>
        <h2>Rituals</h2>

        <br><br>
        @if ($admin)
        <form method="get" action="/rituals/create" id="create">
        </form>
        <button type="submit" form='create' class="btn btn-warning">New Ritual</button>
        <br><br>
        @else
            <?php $admin = '0'; ?>
        @endif

        <h3>Choose one ritual</h3>
        <form method="get" action="/rituals/one" id="oneritual">
            @csrf
            <input type="hidden" name="admin" value="{{ $admin }}">

            <label for="year">Year:</label>
            <select name="year" id="year">
                <?php foreach ($activeYears as $year) { ?>
                <option value="{{ $year }}" >
                    <?php echo $year; ?>
                </option>
                <?php
                }
                ?>
            </select>

            <select name="name" id="name">
                <?php $names=['Samhain', 'Yule', 'Imbolc', 'Spring', 'Beltaine', 'Summer', 'Lughnasadh', 'Fall', 'PaganPride'];
                foreach($names as $item){
                ?>
                <option value="{{ $item }}" >
                    <?php echo $item; ?>
                </option>
                <?php
                }
                ?>
            </select>
            <button type="submit" form='oneritual' class="btn btn-go">One Ritual</button>
            <br><br>
        </form>

                <h3>Choose a ritual year</h3>

        <?php foreach ($activeYears as $year) { ?>
                    <li>
                        <a href="/rituals/{{ $year }}/{{ $admin }}/year">{{ $year }}</a>
                    </li>
        <?php } ?>

    </div>
    <br>
@endsection
