<?php

use Illuminate\Auth\Access\Events\GateEvaluated;
use Illuminate\Cache\Events\CacheHit;
use Illuminate\Database\Events\QueryExecuted;
use Kbaas\Exestat\Presenters\CacheHitPresenter;
use Kbaas\Exestat\Presenters\GateEvaluatedPresenter;
use Kbaas\Exestat\Presenters\QueryExecutedPresenter;

return [
    /**
     * Maximum amount of requests to cache
     */
    'cache_limit' => 50,

    /**
     * Whether to capture all fired events
     */
    'capture_events' => true,

    /**
     * Customize the description for these events
     */
    'event_presenters' => [
        QueryExecuted::class => QueryExecutedPresenter::class,
        GateEvaluated::class => GateEvaluatedPresenter::class,
        CacheHit::class => CacheHitPresenter::class
    ],

    /**
     * The key used to cache request information
     * Shouldn't need to edit this
     */
    'cache_key' => 'exestat_requests'
];
