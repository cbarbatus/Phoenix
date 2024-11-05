@extends('layouts.app')

@section('content')
    <div class='container'>
        <h2>Edit a Member</h2>
        <br><br>
        <form method="post" action="/members/{{ $member->id }}" id="edit">
            @csrf
            @method('put')
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" id="first_name" value="{{ $member->first_name }}">
            <br>
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" id="last_name" value="{{ $member->last_name }}">
            <br>
            <label for="mid_name">Mid Name:</label>
            <input type="text" name="mid_name" id="midt_name" value="{{ $member->mid_name }}">
            <br>
            <label for="rel_name">Religious Name:</label>
            <input type="text" name="rel_name" id="mid_rel" value="{{ $member->rel_name }}">
            <br>

            @if ($change_members)
            <label for="status">Status:</label>
            <input type="text" name="status" id="status" size="10" value="{{ $member->status }}">
            <br>
            <label for="category">Category:</label>
            <input type="text" name="category" id="category" size="10" value="{{ $member->category }}">
            <br>
            @else
            <input hidden type="text" name="status" id="status" size="10" value="{{ $member->status }}">
            <input hidden type="text" name="category" id="category" size="10" value="{{ $member->category }}">
            @endif

            <label for="address">Address:</label>
            <input type="text" name="address" id="address" size="60" value="{{ $member->address }}">
            <br>
            <label for="pri_phone">Primary Phone:</label>
            <input type="text" name="pri_phone" id="pri_phone" size="14" value="{{ $member->pri_phone }}">
            <br>
            <label for="alt_phone">Alternate Phone:</label>
            <input type="text" name="alt_phone" id="alt_phone" size="14" value="{{ $member->alt_phone }}">
            <br>

            <label for="email">Email:</label>
            <input type="text" name="email" id="email" size="60" value="{{ $member->email }}">
            <br>

            @if ($change_members)
                <label for="joined">Joined:</label>
            <input type="text" name="joined" id="joined" size="10" value="{{ $member->joined }}">
            <br>
            <label for="adf">ADF ID Number:</label>
            <input type="text" name="adf" id="adf" size="5" value="{{ $member->adf }}">
            @else
                <input hidden type="text" name="joined" id="joined" size="10" value="{{ $member->joined }}">
                <input hidden type="text" name="adf" id="adf" size="5" value="{{ $member->adf }}">
            @endif
            <br><br>
        </form>
        <button type="submit" form='edit' class="btn btn-go">Submit</button>

    </div>
    <br>
@endsection
