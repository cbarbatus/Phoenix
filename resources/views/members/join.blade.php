@extends('layouts.app')

@section('content')
    <div class='container'>
        <h2>Join Our Grove</h2>
        <br><br>



        <form method="post" action="/members/join" id="create">
            @csrf

            <input type="checkbox" name="discuss" required> <b>I have discussed dues and other expectations of membership with the Senior Druid.</b>
            <br><br>

            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" id="first_name" required>
            <br>
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" id="last_name" required>
            <br>
            <label for="rel_name">Religious Name:</label>
            <input type="text" name="rel_name" id="rel_name">
            <br>
            <input hidden type="text" name="status" id="status" size="10" value="Current">
            <input hidden type="text" name="category" id="category" size="10" value="Joiner">
            <label for="address">Address:</label>
            <input type="text" name="address" id="address" size="60" value="street address;city;state;zip" required>
            <br>
            <label for="pri_phone">Primary Phone:</label>
            <input type="phone" name="pri_phone" id="pri_phone" value="aaa nnn-nnnn" size="14">
            <br>
            <label for="alt_phone">Alternate Phone:</label>
            <input type="phone" name="alt_phone" id="alt_phone" value="aaa nnn-nnnn" size="14">
            <br>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" size="60" required>
            <br>
            <label for="joined">Joined:</label>
            <input type="date" name="joined" id="joined" value="yyyy-mm-dd" size="10" required>
            <br><br>
        </form>
        <button type="submit" form='create' class="btn btn-go">Submit</button>

    </div>
    <br>
@endsection
