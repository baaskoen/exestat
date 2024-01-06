<?php

use Kbaas\Exestat\Helpers\ExestatHelper;

/**
 * @return ExestatHelper
 */
function exestat(): ExestatHelper
{
    return app(ExestatHelper::class);
}

/**
 * @param string $sql
 * @param array $bindings
 * @return string
 */
function query_to_string(string $sql, array $bindings = []): string
{
    if (count($bindings) > 0) {
        return vsprintf(str_replace('?', "'%s'", $sql), $bindings);
    }

    return $sql;
}
