@php use Kbaas\Exestat\ExestatCachedResult; @endphp
@php use Kbaas\Exestat\Enums\ExestatSort; @endphp
@extends('exestat::layout')

@section('content')
    <div class="my-lg flex gutter-md items-center gutter-md">
        @if($currentSort === ExestatSort::LATEST)
            <a href="{{ route('exestat.index', ['sort' => 'duration']) }}">
                <button>Sort by duration</button>
            </a>
        @endif

        @if($currentSort === ExestatSort::DURATION)
            <a href="{{ route('exestat.index', ['sort' => 'latest']) }}">
                <button>Sort by latest</button>
            </a>
        @endif
    </div>
    <div class="block">
        @php /** @var ExestatCachedResult $result */ @endphp
        @forelse($results as $result)
            <div class="flex justify-between border-bottom items-center pa-md">
                <div>
                    <span>{{ $result->getRequestMethod() }}: {{ $result->getRequestPath() }}</span>
                    <div>Duration: <strong>{{ $result->totalTimeElapsedInMilliseconds() }} ms</strong></div>
                    <div><small>{{ $result->getDateTime()->diffForHumans() }}</small></div>
                </div>

                <a href="{{ route('exestat.detail', $result->getUuid()) }}">
                    <button>
                        Show details
                    </button>
                </a>
            </div>
        @empty
            <span>No requests found!</span>
        @endforelse
    </div>
@endsection
