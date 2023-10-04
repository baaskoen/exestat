@php use Kbaas\Exestat\ExestatCachedResult; @endphp
@php use Kbaas\Exestat\ExestatEvent; @endphp
@php /** @var ExestatCachedResult $result */ @endphp
@extends('exestat::layout')

@section('content')
    <div class="my-lg flex items-center justify-between">

        <div class="flex gutter-md items-center">
            <a href="javascript:history.back()">
                <button>← Go back</button>
            </a>

            <strong>{{ $result->getRequestPath() }}</strong>
            <strong>{{ $result->totalTimeElapsedInMilliseconds() }} ms</strong>
            <small>{{ $result->getDateTime()->diffForHumans() }}</small>
        </div>
    </div>

    <div class="block">
        <table>
            @php /** @var ExestatEvent $event */ @endphp
            @foreach(array_reverse($result->getEvents()) as $key => $event)
                    <?php $time = $event->totalTimeElapsedInMilliseconds() ?>

                @if(!$loop->first)
                    <tr>
                        <td class="text-center">
                            <div
                                style="border-left: 5px solid {{ $event->getColorCode() }}; color: {{ $event->getColorCode() }}; padding: {{ $event->getPadding($result) }}px;">
                                <strong>
                                    <span>Execution time: {{ $time }} ms.</span>
                                    <span>Percentage: {{ $event->getPercentage($result) }}%</span>
                                </strong>
                            </div>
                        </td>
                    </tr>
                @endif
                <tr>
                    <td>
                        <div class="flex justify-between items-center">
                            <span class="text-primary"><strong>→ {{ $event->getTitle() }}</strong></span>
                            @if($event->getDescription())
                                <button id="button-{{ $key }}" onclick="showDetails('{{ $key }}')">Show details</button>
                            @endif
                        </div>
                    </td>
                </tr>
                <tr style="display: none;" id="details-{{ $key }}">
                    <td class="pa-md">
                        {{ $event->getDescription() }}
                    </td>
                </tr>
            @endforeach
        </table>

    </div>
@endsection

@section('scripts')
    <script>
        function showDetails(key) {
            document.getElementById(`details-${key}`).style.display = '';

            hideElementById(`button-${key}`)
        }

        function hideElementById(id) {
            document.getElementById(id).style.display = 'none';
        }
    </script>
@endsection
