<?php

namespace Kbaas\Exestat\Presenters;

use Illuminate\Auth\Access\Events\GateEvaluated;
use Illuminate\Database\Eloquent\Model;

class GateEvaluatedPresenter extends ExestatPresenter
{
    /**
     * @param array $args
     * @return string
     */
    public function toDescription(array $args): string
    {
        /** @var GateEvaluated $event */
        $event = $args[0];
        $arguments = '';

        foreach ($event->arguments as $argument) {
            if (is_string($argument)) {
                $arguments .= $argument;
                continue;
            }

            if ($argument instanceof Model) {
                $arguments .= get_class($argument) . '#' . $argument->getKey();
            }
        }
        $result = $event->result ? 'true' : false;

        return "Ability: [$event->ability], arguments: [{$arguments}], result: [$result]";
    }
}
