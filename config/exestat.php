<?php

use Illuminate\Database\Events\QueryExecuted;
use Kbaas\Exestat\Presenters\QueryExecutedPresenter;

return [
    'presenters' => [
        QueryExecuted::class => QueryExecutedPresenter::class
    ]
];
