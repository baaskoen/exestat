<?php

namespace Kbaas\Exestat;

use Illuminate\Support\Carbon;

class ExestatCachedResult
{
    /**
     * @var Carbon
     */
    public Carbon $dateTime;

    /**
     * @var string
     */
    public string $requestUri;

    /**
     * @var string
     */
    public string $requestFullUrl;

    /**
     * @var float
     */
    public float $totalTimeElapsed;

    /**
     * @var array
     */
    public array $events;

    /**
     * @param float $totalTimeElapsed
     * @param array $events
     */
    public function __construct(float $totalTimeElapsed, array $events)
    {
        $this->dateTime = now();
        $this->requestUri = request()->getUri();
        $this->requestFullUrl = request()->fullUrl();
        $this->totalTimeElapsed = $totalTimeElapsed;
        $this->events = $events;
    }
}
