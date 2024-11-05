@extends('layouts.app')

@section('content')
    <h2>Members</h2>
    <br>


    @canany(['change all','change members'])


        <form method="get" action="/members/create" id="create">
        </form>
        <button type="submit" form='create' class="btn btn-warning">New Member</button>
        <br><br>

        <form method="get" action="/members/restore" id="restore">
            <button type="submit" form='restore' class="btn btn-info"><b>Restore Member</b></button>
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" id="first_name" required>
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" id="last_name" required>
            <br>
        </form>
        <br><br>

        <form method="get" action="/members/full" id="full">
        </form>
        <button type="submit" form='full' class="btn btn-warning">Show All</button>

        <br><br>


        <br><br>

    @endcan


        @if ( !($members->count()) )
        You have no members
        @else
            <table class="table table-striped">
                <thead>
                <tr style="font-weight:bold">
                    @canany(['change all','change members'])
                        <td>ID</td>
                    @endcan
                    <td>Name</td>
                    <td></td>

                    @canany(['change all','change members'])
                        <td>Status</td>
                        <td>User</td>
                    @endcan
                    <td>Joined</td>
                    <td>Email</td>
                    <td>Phone</td>
                    <td>ADF</td>
                    <td colspan="2">Action</td>
                </tr>
                </thead>
                <tbody>
                @foreach($members as $member)
                    @if (( $member->first_name[0] != '_' ) || (Auth::user()->can('change members')) || ($member->user_id == $user->id) )
                        <tr>
                            @canany(['change all','change members'])
                                <td>{{$member->id}}</td>
                            @endcan

                            <td>{{$member->first_name}} {{$member->mid_name}} {{$member->last_name}}</td>
                            <td>{{$member->category}}</td>
                                @canany(['change all','change members'])
                                <td>{{$member->status}}</td>
                                <td>{{$member->user_id}}</td>
                                @endcan
                            <td>{{$member->joined}}</td>
                            <td>{{$member->email}}</td>
                            <td>{{$member->pri_phone}}</td>
                                <td>{{$member->adf}}</td>
                            <td>
                                @if ( ($change_own & ($member->user_id == $user->id)) || $change_members || $change_all)

                                    <form method="get" action="/members/{{ $member['id']}}/edit" id="edit">
                                    @csrf
                                    @method('GET')
                                    <button type="submit" class="btn btn-warning" >Edit</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        @endif


<br>
@endsection
