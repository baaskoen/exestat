@php
    use Kbaas\Exestat\ExestatEvent;
    $omittedEvents = [];
    $calculatedElapsed = 0;
    /** @var ExestatEvent $event */
@endphp
@foreach($events as $key => $event)
    @php
        $time = $event->getTotalTimeElapsedInMilliseconds();
        $calculatedElapsed += $time;
    @endphp

    @if(!$loop->last && $event->getPercentage($result) < $omitThreshold)
        @php $omittedEvents[] = $event; @endphp
        @continue
    @endif

    @if(count($omittedEvents) > 0)
        <div style="border-left: 5px solid lightgray;" class="text-center pa-sm relative border-bottom">
            <div class="tooltip">
            <span>
                <small>+ {{ count($omittedEvents) }} omitted short transition(s)</small>
            </span>
                <dialog>
                    <div class="flex justify-between items-center mb-md">
                        <span class="font-bold">Omitted short transition(s)</span>
                        <button onclick="closeAllTooltips()">Close</button>
                    </div>

                    <div style="max-height: 60vh;" class="overflow-auto">
                        @include('exestat::partials.events', ['events' => $omittedEvents, 'omitThreshold' => 0])
                    </div>
                </dialog>
            </div>
                <?php $omittedEvents = [] ?>
        </div>
    @endif

    <div class="pa-sm relative border-bottom">
        <div class="flex items-center gutter-md justify-center">
            @if($event->isEvent())
                <small class="font-bold">🔥 {{ $event->getTitle() }}</small>
            @else
                <small class="font-bold text-primary">⏲️ {{ $event->getTitle() }}</small>
            @endif
        </div>
        @if($event->getDescription())
            <div class="grey-1 pa-sm mt-sm rounded text-center relative">
                @if($event->getTitle() === 'Illuminate\Database\Events\QueryExecuted')
                    @foreach($duplicatedQueries as $duplicatedQuery)
                        @if($duplicatedQuery['sql'] === $event->getDescription())
                            <div class="absolute-top-right top--10">
                                <div class="warning">
                                    <small>Duplicated ({{ $duplicatedQuery['calls'] }})</small>
                                </div>
                            </div>
                            @break
                        @endif
                    @endforeach
                @endif

                <small class="overflow-auto">{{ $event->getDescription() }}</small>
            </div>
        @endif
    </div>

    @if($omitThreshold === 0 || !$loop->last)
        <div style="border-left: 5px solid {{ $event->getColorCode() }};">
            <div class="flex gutter-md items-center justify-between border-bottom pa-sm">
                <span>⏬</span>
                <div class="flex items-center gutter-md">
                    <div style="color: {{ $event->getColorCode() }};" class="chip duration">{{ $time }} ms</div>
                    <div style="color: {{ $event->getColorCode() }};"
                         class="chip duration">{{ $event->getPercentage($result) }}%
                    </div>
                    <div class="chip duration">{{ $calculatedElapsed }} ms</div>
                </div>
                <span>⏬</span>
            </div>
        </div>
    @endif
@endforeach
