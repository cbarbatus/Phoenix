@extends('layouts.app')

@section('content')
    <div class='container'>
        <h2>{{ $cat }} Books</h2>
        <br>
        <h4>Please note that if you wish to purchase any of these titles online,
            the photos are links to Amazon.com Books to make them available for easy ordering.</h4>

        @php ($cur_type = '') @endphp
        {{ $cur_type }}
            @foreach ($books as $book)
                @php if ($book->type != $cur_type) {
                    echo("<br><br>");
                    $cur_type = $book->type;
                    echo "<hr><h3> ".$cur_type." </h3><hr>";
                    }
                @endphp
                <a href="http://www.amazon.com/exec/obidos/redirect?link_code=as2&path=ASIN/{{ $book->amazon }}&tag=ravenscrygrov-20&camp=1789&creative=9325">
                    <img border="0" src="http://ec1.images-amazon.com/images/P/{{ $book->amazon }}.01._AA_SCMZZZZZZZ_.jpg"></a>
                <h4>{{ $book->title }}</h4>
                <h5>{{ $book->author }}</h5>
                {{ $book->description }}
                <hr>
            @endforeach
    </div>
    <br><br>
@endsection
