@extends('layouts.app')

@section('content')
    <h2>Rituals</h2>

    <br>


    <div class='container' >
        @if ( !($rituals->count()) )
        You have no matching rituals
        @else
            <table class="table table-striped">
                <thead>
                <tr style="font-weight:bold">
                    <td>ID</td>
                    <td>Name</td>
                    <td>Year</td>
                    <td>Title</td>
                    <td>Culture</td>
                    <td colspan="2">Action</td>
                </tr>
                </thead>
                <tbody>
                @foreach($rituals as $ritual)
                    <tr>
                        <td>{{$ritual->id}} </td>
                        <td>{{$ritual->name}} </td>
                        <td>{{$ritual->year}}</td>
                        <td>{{$ritual->title}}</td>
                        <td>{{$ritual->culture}}</td>

                        <td>
                            @if($ritual->liturgy_base != '')
                                <form method="get" action="/rituals/{{ $ritual['id']}}/text" id="show">
                                    <button type="submit" class="btn btn-go" >Show</button>
                                </form>
                            @endif
                        </td>
                        <td>
                            @if($ritual->liturgy_base != '')
                                <form method="get" action="/liturgy/{{ $ritual['id']}}/get" id="spam">
                                    <button type="submit" class="btn btn-go" >Get</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

<br>
@endsection
