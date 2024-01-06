<?php

namespace Kbaas\Exestat\Presenters;

use Illuminate\Cache\Events\CacheHit;
use Illuminate\Support\Str;

class CacheHitPresenter extends ExestatPresenter
{
    /**
     * @param array $args
     * @return string
     */
    public function toDescription(array $args): string
    {
        /** @var CacheHit $event */
        $event = $args[0];

        if (Str::startsWith($event->key, 'leqc:')) {
            return '';
        }

        return $event->key;
    }
}
