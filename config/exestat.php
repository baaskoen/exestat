<?php

use Illuminate\Database\Events\QueryExecuted;
use Kbaas\Exestat\Presenters\QueryExecutedPresenter;

return [
    /**
     * Maximum amount of requests to cache
     */
    'cache_limit' => 200,

    /**
     * Whether to capture all fired events
     */
    'capture_events' => false,

    /**
     * Customize the description for these events
     */
    'event_presenters' => [
        QueryExecuted::class => QueryExecutedPresenter::class
    ],
];
