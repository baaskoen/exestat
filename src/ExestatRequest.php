<?php

namespace Kbaas\Exestat;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Kbaas\Exestat\Http\Middleware\IgnoreExestat;

class ExestatRequest
{
    private array $events;

    private ?ExestatEvent $lastEvent = null;

    private float $timeStarted;

    private ?float $timeEnded = null;

    private ?float $totalTimeElapsed = null;

    public function __construct()
    {
        $this->events = [];
        $this->timeStarted = microtime(true);
    }

    /**
     * @param ExestatEvent $event
     * @return array
     */
    public function addEvent(ExestatEvent $event): array
    {
        if ($this->lastEvent) {
            $this->lastEvent->end();
        }

        $this->events[] = $event;
        $this->lastEvent = $event;

        return $this->events;
    }

    /**
     * @return void
     */
    public function end(): void
    {
        $this->timeEnded = microtime(true);
        $this->lastEvent->end();

        $this->totalTimeElapsed = ($this->timeEnded - $this->timeStarted);

        $currentRoute = Route::getCurrentRoute();
        if ($currentRoute && in_array(IgnoreExestat::class, $currentRoute->middleware())) {
            return;
        }

        $this->cacheResults();
    }

    /***
     * @return void
     */
    private function cacheResults(): void
    {
        $key = Exestat::getCacheKey();

        $limit = config('exestat.cache_limit', 200);

        $currentValue = Exestat::getCache();
        $count = count($currentValue);

        if ($count >= $limit) {
            $diffInCount = $count - $limit;
            $currentValue = array_slice($currentValue, $diffInCount + 1);
        }

        Cache::put($key, array_merge($currentValue, [
            new ExestatCachedResult($this->totalTimeElapsed, $this->events)
        ]));
    }

    /**
     * @return bool
     */
    public function hasEnded(): bool
    {
        return $this->timeEnded !== null;
    }

    /**
     * @return ExestatEvent
     */
    public function getLastEvent(): ExestatEvent
    {
        return $this->lastEvent;
    }
}
