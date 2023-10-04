<?php

namespace Kbaas\Exestat;

use Exception;
use Illuminate\Support\Facades\Cache;

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
     * @param string $title
     * @param string|null $description
     * @return void
     * @throws Exception
     */
    public static function start(string $title, ?string $description = null): void
    {
        static::getInstance()->request->addEvent(new ExestatEvent($title, $description));
    }

    /**
     * @return void
     * @throws Exception
     */
    public static function end(): void
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
     * @return string
     */
    public static function getCacheKey(): string
    {
        return 'exestat_requests';
    }

    /**
     * @return array
     */
    public static function getCache(): array
    {
        return Cache::get(static::getCacheKey(), []);
    }
}
