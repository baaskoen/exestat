<?php

namespace Kbaas\Exestat;

use Exception;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Cache;
use Kbaas\Exestat\Enums\ExestatSort;

class Exestat
{
    /**
     * @var ExestatRequest
     */
    private ExestatRequest $request;

    public function __construct()
    {
        $this->request = new ExestatRequest($this);
        $this->request->addEvent(new ExestatEvent('Request started'));
    }

    /**
     * @param string $title
     * @param string|null $description
     * @param bool $isEvent
     * @return void
     */
    public function record(string $title, ?string $description = null, bool $isEvent = false): void
    {
        $this->request->addEvent(new ExestatEvent($title, $description, $isEvent));
    }


    /**
     * @return void
     * @throws Exception
     */
    public function stopRecording(): void
    {
        $this->request->addEvent(new ExestatEvent('Request handled'));
        $this->request->end();
    }

    /**
     * @return bool
     */
    public function hasEnded(): bool
    {
        return $this->request->hasEnded();
    }

    /**
     * @param ExestatSort|null $sort
     * @return array
     */
    public function getCache(ExestatSort $sort = null): array
    {
        $results = Cache::get($this->getCacheKey(), []);

        if ($sort === ExestatSort::LATEST) {
            return array_reverse($results);
        }

        if ($sort === ExestatSort::DURATION) {
            usort($results, function (ExestatCachedResult $a, ExestatCachedResult $b) use ($sort) {
                return $a->getTotalTimeElapsed() > $b->getTotalTimeElapsed() ? -1 : 1;
            });
        }

        return $results;
    }

    /**
     * @return string
     */
    public function getCacheKey(): string
    {
        return config('exestat.cache_key');
    }

    /**
     * @param QueryExecuted $event
     * @return void
     */
    public function addQueryFromEvent(QueryExecuted $event): void
    {
        $this->request->addQuery(new ExestatQuery(
            $event->sql,
            $event->bindings,
            $event->time
        ));
    }

    /**
     * @return void
     */
    public function clearCache(): void
    {
        Cache::forget($this->getCacheKey());
    }
}
