@extends('exestat::layout')

@section('content')
    Cache took: {{ $time  }}ms<br><br>
    <div class="block">
        @php /** @var \Kbaas\Exestat\ExestatCachedResult $result */ @endphp
        @foreach($results as $result)

            {{ $result->dateTime->diffForHumans() }}

            <hr>
        @endforeach
    </div>
@endsection
