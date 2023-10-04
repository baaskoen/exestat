<?php

namespace Kbaas\Exestat\Presenters;

abstract class ExestatPresenter
{
    /**
     * @param array $args
     * @return string
     */
    abstract public function toDescription(array $args): string;
}
