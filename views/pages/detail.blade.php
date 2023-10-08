@php
    use Kbaas\Exestat\ExestatCachedResult;use Kbaas\Exestat\ExestatEvent;use Kbaas\Exestat\ExestatQuery;
@endphp
@php /** @var ExestatCachedResult $result */ @endphp
@php $duplicatedQueries = $result->getDuplicatedQueries(); @endphp
@extends('exestat::layout')

@section('content')
    <div class="my-lg flex gutter-md items-center justify-between">
        @include('exestat::partials.request-title', ['result' => $result])

        <div class="flex gutter-md items-center">
            <small>{{ $result->getTotalMemoryUsedInMbs() }}mb memory</small>
            <small>{{ $result->getDateTime()->format('H:i:s') }} 🕒</small>
            <small class="font-bold">{{ count($result->getQueries()) }} queries</small>
        </div>
    </div>

    <div class="w-8 centered">
        @if(count($duplicatedQueries) > 0)
            <div class="block shadow mb-lg">
                <table class="full-width">
                    <thead>
                    <tr>
                        <th class="text-left">Duplicated query</th>
                        <th class="text-center">Calls</th>
                        <th class="text-left">Total time</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($duplicatedQueries as $query)
                        <tr>
                            <td>
                                <small>{{ $query['sql'] }}</small>
                            </td>
                            <td class="text-center">{{ $query['calls'] }}</td>
                            <td>
                                <div class="chip duration">{{ $query['time'] }} ms</div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="block shadow">
            @php /** @var ExestatEvent $event */ @endphp
            @foreach(array_reverse($result->getEvents()) as $key => $event)
                    <?php $time = $event->getTotalTimeElapsedInMilliseconds() ?>
                @if(!$loop->first)
                    <div
                        class="border-bottom" style="border-left: 5px solid {{ $event->getColorCode() }};">
                        <div
                            class="flex gutter-md py-sm items-center justify-center px-md"
                            style="color: {{ $event->getColorCode() }};"
                        >
                            <div class="chip duration">{{ $time }} ms</div>
                            <div
                                class="arrow">@include('exestat::partials.arrow', ['color' => $event->getColorCode(), 'size' => 12 ])</div>
                            <div class="chip duration">{{ $event->getPercentage($result) }} %</div>
                        </div>
                    </div>
                @endif

                <div class="pa-sm relative border-bottom">

                    <div class="flex items-center gutter-md justify-center font-bold">
                        @if($event->isEvent())
                            <small>{{ $event->getTitle() }}</small>
                        @else
                            <small class="text-primary">{{ $event->getTitle() }}</small>
                        @endif
                    </div>
                    @if($event->getDescription())
                        <div class="text-center grey-1 mx-md pa-sm mt-sm rounded">
                            <small>{{ $event->getDescription() }}</small>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function hideElementById(id) {
            document.getElementById(id).style.display = 'none';
        }
    </script>
@endsection
