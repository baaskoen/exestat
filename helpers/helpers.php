<?php

use Kbaas\Exestat\Helpers\ExestatHelper;

/**
 * @return ExestatHelper
 */
function exestat(): ExestatHelper
{
    return app(ExestatHelper::class);
}
