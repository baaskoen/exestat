<?php

namespace Kbaas\Exestat;

use Exception;
use Illuminate\Support\Facades\Cache;
use Kbaas\Exestat\Enums\ExestatSort;

class Exestat
{
    private static ?Exestat $instance = null;

    private ExestatRequest $request;

    public function __construct()
    {
        $this->request = new ExestatRequest();
        $this->request->addEvent(new ExestatEvent('ExeStat initialized'));
    }

    /**
     * @param string $title
     * @param string|null $description
     * @return void
     * @throws Exception
     */
    public static function record(string $title, ?string $description = null): void
    {
        static::getInstance()->request->addEvent(new ExestatEvent($title, $description));
    }

    /**
     * @return Exestat
     */
    private static function getInstance(): Exestat
    {
        if (!static::$instance) {
            static::init();
        }

        return static::$instance;
    }

    /**
     * @return void
     */
    public static function init(): void
    {
        if (static::$instance) {
            return;
        }

        static::$instance = new Exestat();
    }

    /**
     * @return void
     * @throws Exception
     */
    public static function stopRecording(): void
    {
        static::getInstance()->request->addEvent(new ExestatEvent('ExeStat ended'));
        static::getInstance()->request->end();
    }

    /**
     * @return bool
     */
    public static function hasEnded(): bool
    {
        return static::getInstance()->request->hasEnded();
    }

    /**
     * @param ExestatSort|null $sort
     * @return array
     */
    public static function getCache(ExestatSort $sort = null): array
    {
        $results = Cache::get(static::getCacheKey(), []);

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
    public static function getCacheKey(): string
    {
        return 'exestat_requests';
    }

    /**
     * @return void
     */
    public static function clearCache(): void
    {
        Cache::forget(static::getCacheKey());
    }
}
