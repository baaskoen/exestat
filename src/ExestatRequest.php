<?php

namespace Kbaas\Exestat;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Kbaas\Exestat\Http\Middleware\IgnoreExestat;

class ExestatRequest
{
    /**
     * @var Exestat
     */
    private Exestat $exestat;

    /**
     * @var array
     */
    private array $events;

    /**
     * @var array
     */
    private array $queries;

    /**
     * @var ExestatEvent|null
     */
    private ?ExestatEvent $lastEvent = null;

    /**
     * @var float
     */
    private float $timeStarted;

    /**
     * @var float|null
     */
    private ?float $timeEnded = null;

    /**
     * @var float|null
     */
    private ?float $totalTimeElapsed = null;

    /**
     * @var int|null
     */
    private ?int $totalMemoryUsed = null;

    /**
     * @param Exestat $exestat
     */
    public function __construct(Exestat $exestat)
    {
        $this->exestat = $exestat;
        $this->events = [];
        $this->queries = [];
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
        $this->totalMemoryUsed = memory_get_peak_usage(true);
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
        $limit = config('exestat.cache_limit', 200);

        $currentValue = $this->exestat->getCache();
        $count = count($currentValue);

        if ($count >= $limit) {
            $diffInCount = $count - $limit;
            $currentValue = array_slice($currentValue, $diffInCount + 1);
        }

        Cache::put($this->exestat->getCacheKey(), array_merge($currentValue, [
            new ExestatCachedResult($this->totalTimeElapsed, $this->events, $this->queries, $this->totalMemoryUsed)
        ]));
    }

    /**
     * @param ExestatQuery $query
     * @return void
     */
    public function addQuery(ExestatQuery $query): void
    {
        $this->queries[] = $query;
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

    /**
     * @return int|null
     */
    public function getTotalMemoryUsed(): ?int
    {
        return $this->totalMemoryUsed;
    }
}
