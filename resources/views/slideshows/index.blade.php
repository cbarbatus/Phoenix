@extends('layouts.app')

@section('content')

    <div class='container'>
        <h2>Slideshows Selection</h2>

        <br><br>
        @if ($admin)
        <form method="get" action="/slideshows/create" id="create">
        </form>
        <button type="submit" form='create' class="btn btn-warning">New Slideshow</button>
        @else
            <?php $admin = '0'; ?>
        @endif

        <h3>Choose one slideshow</h3>
        <form method="get" action="/slideshows/{{ $admin }}/one" id="oneshow">
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
                <?php foreach ($activeNames as $name) { ?>
                <option value="{{ $name }}" >
                    <?php echo $name; ?>
                </option>
                <?php
                }
                ?>
            </select>

            <button type="submit" form='oneshow' class="btn btn-go">Select</button>
            <br><br>
        </form>

                <h3>Choose an event year</h3>

        <?php foreach ($activeYears as $year) { ?>
                    <li>
                        <a href="/slideshows/{{ $year }}/{{ $admin }}/year">{{ $year }}</a>
                    </li>
        <?php } ?>

    </div>
    <br>
@endsection
