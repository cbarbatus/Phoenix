<!-- /resources/views/projects/index.blade.php -->
<!-- from rcglaravel -->

@extends('layouts.app')

@section('content')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    @if (!is_null($contacts))
        <div class="flash alert-danger">
            <p>There are contacts awaiting reply.</p>
        </div>
    @endif


    <div class="container">
        <h2 style="text-align:center; color:black; text-shadow: 2px 2px 4px #505050;">
            <b>Serving the L.A. Pagan community since 1999!</b>
        </h2>
        <h5 style="text-align:center; color:black; text-shadow: 2px 2px 4px #505050;">
        Raven's Cry Grove is an inclusive, anti-racist community, welcoming and respecting all ethnicities, national origins, sexual orientations & gender identities.
        </h5>
            <img src="/img/webpage_cover_2023.jpg"
             style="display:block; margin-left:auto; margin-right:auto; width:100%; height:auto; border:5px groove black;">
        <br><br>

        Click or touch to show a section. <br><br>
            @foreach($sections as $section)

            <br> <a href="/sections/{!! $section->id !!}/on" >
                <h5> {{ $section->name  }} </h5>
            </a>


                @if ( $section->showit )
                    <br> <a href="/sections/{!! $section->id !!}/off" > CLOSE THIS SECTION </a>
                    <br><br>

                    @foreach( $section->elements as $element )
                        <br><br>
                         {!!  $element->item !!}
                    @endforeach

                    <br> <a href="/sections/{!! $section->id !!}/off" > CLOSE THIS SECTION </a>
                        <br><br>
                     @endif



            @endforeach


                    <br><br>
    </div>


        <div class="foot" align="center">
            <a href="/contact"><b><span style='color:#58774e;; font-size:140%;'>Contact Us</span></b></a><br>
            <br>
            <a href="https://www.facebook.com/ravenscrygrove/">
                <img src="/img/facebook_button.gif">
            </a>
            <br><br>
        </div>




@endsection

