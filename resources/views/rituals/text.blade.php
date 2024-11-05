@extends('layouts.app')

@section('content')

    <div class='container' style="line-height: 1;">
        <br><br>
        <div class='liturgy' style="background-color: white; padding:20pt; ">
            @for ($i = $parms[0]; $i < $parms[1]; $i++)
                {!! $parms[2][$i] !!}
            @endfor
        </div>
    </div>

@endsection

