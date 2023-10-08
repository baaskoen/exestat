@php use Kbaas\Exestat\ExestatCachedResult; @endphp
@php use Kbaas\Exestat\Enums\ExestatSort; @endphp
@extends('exestat::layout')

@section('content')
    @php $count = count($results);  @endphp
    @if($count > 0)
        <div class="my-lg flex gutter-md items-center gutter-md">
            <div>
                <strong>
                    Showing
                    @if($currentSort === ExestatSort::LATEST)
                        latest
                    @else
                        longest
                    @endif
                    request ({{ $count }})
                </strong>
            </div>

            <div>
                @if($currentSort === ExestatSort::DURATION)
                    <a href="{{ route('exestat.index', ['sort' => 'latest']) }}">
                        <button>Sort by latest</button>
                    </a>
                @endif

                @if($currentSort === ExestatSort::LATEST)
                    <a href="{{ route('exestat.index', ['sort' => 'duration']) }}">
                        <button>Sort by duration</button>
                    </a>
                @endif
            </div>
        </div>
    @endif
    <div class="block pa-md shadow">
        @php /** @var ExestatCachedResult $result */ @endphp
        @forelse($results as $result)
            <a
                href="{{ route('exestat.detail', $result->getUuid()) }}"
                class="result flex justify-between items-center pa-sm border-bottom"
            >
                @include('exestat::partials.request-title', ['result' => $result])

                <div>
                    <small>{{ $result->getDateTime()->diffForHumans() }} 🕒</small>
                </div>
            </a>
        @empty
            <div>
                <strong>🔎 No requests found.</strong>
                <div>Click around in your app and refresh this page! 🍀</div>
            </div>
        @endforelse
    </div>
@endsection
