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
     * @var array
     */
    private array $queries;

    /**
     * @var int
     */
    private int $totalMemoryUsed;

    /**
     * @param float $totalTimeElapsed
     * @param array $events
     * @param array $queries
     * @param int $totalMemoryUsed
     */
    public function __construct(float $totalTimeElapsed, array $events, array $queries, int $totalMemoryUsed)
    {
        $this->uuid = Str::uuid();
        $this->dateTime = now();
        $this->requestPath = request()->path();
        $this->requestFullUrl = request()->fullUrl();
        $this->requestMethod = request()->method();
        $this->totalTimeElapsed = $totalTimeElapsed;
        $this->events = $events;
        $this->queries = $queries;
        $this->totalMemoryUsed = $totalMemoryUsed;
    }

    /**
     * @param int $precision
     * @return float
     */
    public function getTotalTimeElapsedInMilliseconds(int $precision = 2): float
    {
        return round($this->totalTimeElapsed * 1000, $precision);
    }

    /**
     * @param int $precision
     * @return float
     */
    public function getTotalMemoryUsedInMbs(int $precision = 2): float
    {
        $used = (float)$this->totalMemoryUsed;

        return round($used / 1024 / 1024, $precision);
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
     * @return array
     */
    public function getQueries(): array
    {
        return $this->queries;
    }

    /**
     * @return array
     */
    public function getDuplicatedQueries(): array
    {
        $queries = [];

        /** @var ExestatQuery $query */
        foreach ($this->queries as $query) {
            $key = $query->getUniqueKey();

            if (isset($queries[$key])) {
                $queries[$key]['time'] += $query->getTime();
                $queries[$key]['calls'] += 1;
                continue;
            }

            $queries[$query->getUniqueKey()] = [
                'sql' => $query->getFullQuery(),
                'time' => $query->getTime(),
                'calls' => 1
            ];
        }

        return array_filter($queries, fn($query) => $query['calls'] > 1);
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

    /**
     * @return int
     */
    public function getTotalMemoryUsed(): int
    {
        return $this->totalMemoryUsed;
    }
}
