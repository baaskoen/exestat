<?php

namespace Kbaas\Exestat\Presenters;

use Illuminate\Database\Events\QueryExecuted;

class QueryExecutedPresenter extends ExestatPresenter
{

    /**
     * @param array $args
     * @return string
     */
    public function toDescription(array $args): string
    {
        /** @var QueryExecuted $event */
        $event = $args[0];

        return "Query ({$event->time} ms): [$event->sql]";
    }
}
