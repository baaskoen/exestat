@php
    use Kbaas\Exestat\ExestatCachedResult;
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

    <div class="centered">
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

        <div class="block shadow mb-lg">
            <!-- Timeline overview -->
            <div class="flex items-center gutter justify-between pa-md border-bottom">
                <span class="font-bold">Overview of request events from start to end</span>
                <!-- Input for omitting transitions -->
                <div>
                    <label for="omit_threshold"><small>Omit transitions shorter than</small></label>
                    <input style="width: 50px;" step="any" type="number"
                           onchange="onOmitThresholdChange(event)"
                           id="omit_threshold" name="omit_threshold" value="{{ $omitThreshold }}"/>
                    <small>ms</small>
                </div>

            </div>
            @include('exestat::partials.events', ['events' => $result->getEvents(), 'omitThreshold' => $omitThreshold])
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        /**
         * Handle tooltips (dialog) in simple way
         */
        document.addEventListener('DOMContentLoaded', function () {
            const tooltips = document.getElementsByClassName('tooltip');

            for (let i = 0; i < tooltips.length; i++) {
                const tooltip = tooltips[i];

                const firstChild = tooltip.querySelector('span');
                const dialogChild = tooltip.querySelector('dialog');

                if (firstChild && dialogChild) {
                    firstChild.style.cursor = 'pointer';
                    firstChild.style['text-decoration'] = 'underline';

                    firstChild.onclick = () => {
                        closeAllTooltips();

                        dialogChild.toggleAttribute('open');
                    }
                }
            }
        });

        /**
         * Close all tooltips
         */
        function closeAllTooltips() {
            const dialogs = document.getElementsByTagName('dialog');
            for (let i = 0; i < dialogs.length; i++) {
                dialogs[i].removeAttribute('open');
            }
        }

        /**
         * @param event
         */
        function onOmitThresholdChange(event) {
            const currentUrl = window.location.href;

            const regex = /[?&]omit_threshold=[^&]*/;

            if (regex.test(currentUrl)) {
                window.location.href = currentUrl.replace(window.location, `?omit_threshold=${event.target.value}`);
            } else {
                const separator = currentUrl.includes('?') ? '&' : '?';
                window.location.href = `${currentUrl}${separator}omit_threshold=${event.target.value}`;
            }
        }
    </script>
@endsection
