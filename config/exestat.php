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
    'capture_events' => true,

    /**
     * Customize the description for these events
     */
    'event_presenters' => [
        QueryExecuted::class => QueryExecutedPresenter::class
    ],

    /**
     * The key used to cache request information
     * Shouldn't need to edit this
     */
    'cache_key' => 'exestat_requests'
];
