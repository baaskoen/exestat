<?php

namespace Kbaas\Exestat;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ExestatCachedResult
{
    /**
     * @var string
     */
    private string $uuid;

    /**
     * @var Carbon
     */
    private Carbon $dateTime;

    /**
     * @var string
     */
    private string $requestPath;

    /**
     * @var string
     */
    private string $requestFullUrl;

    /**
     * @var string
     */
    private string $requestMethod;

    /**
     * @var float
     */
    private float $totalTimeElapsed;

    /**
     * @var array
     */
    private array $events;

    /**
     * @param float $totalTimeElapsed
     * @param array $events
     */
    public function __construct(float $totalTimeElapsed, array $events)
    {
        $this->uuid = Str::uuid();
        $this->dateTime = now();
        $this->requestPath = request()->path();
        $this->requestFullUrl = request()->fullUrl();
        $this->requestMethod = request()->method();
        $this->totalTimeElapsed = $totalTimeElapsed;
        $this->events = $events;
    }

    /**
     * @return float
     */
    public function totalTimeElapsedInMilliseconds(): float
    {
        return round($this->totalTimeElapsed * 1000, 2);
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return Carbon
     */
    public function getDateTime(): Carbon
    {
        return $this->dateTime;
    }

    /**
     * @return string
     */
    public function getRequestPath(): string
    {
        return $this->requestPath;
    }

    /**
     * @return string
     */
    public function getRequestFullUrl(): string
    {
        return $this->requestFullUrl;
    }

    /**
     * @return array
     */
    public function getEvents(): array
    {
        return $this->events;
    }

    /**
     * @return float
     */
    public function getTotalTimeElapsed(): float
    {
        return $this->totalTimeElapsed;
    }

    /**
     * @return string
     */
    public function getRequestMethod(): string
    {
        return $this->requestMethod;
    }
}
