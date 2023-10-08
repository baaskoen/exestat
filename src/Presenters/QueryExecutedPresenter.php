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
        return vsprintf(str_replace('?', "'%s'", $event->sql), $event->bindings);
    }
}
