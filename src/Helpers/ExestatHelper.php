<?php

namespace Kbaas\Exestat\Helpers;

use Kbaas\Exestat\Exestat;

class ExestatHelper
{
    /**
     * @var Exestat
     */
    private Exestat $exestat;

    /**
     * @param Exestat $exestat
     */
    public function __construct(Exestat $exestat)
    {
        $this->exestat = $exestat;
    }

    /**
     * @param string $title
     * @param string|null $description
     * @return void
     */
    public function record(string $title, ?string $description = null): void
    {
        $this->exestat->record($title, $description, false);
    }
}
