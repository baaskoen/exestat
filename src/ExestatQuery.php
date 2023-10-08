<?php

namespace Kbaas\Exestat;

class ExestatQuery
{
    /**
     * @var string
     */
    private string $sql;

    /**
     * @var array
     */
    private array $bindings;

    /**
     * @var float
     */
    private float $time;

    /**
     * @param string $sql
     * @param array $bindings
     * @param float $time
     */
    public function __construct(string $sql, array $bindings, float $time)
    {
        $this->sql = $sql;
        $this->bindings = $bindings;
        $this->time = $time;
    }

    /**
     * @return string
     */
    public function getSql(): string
    {
        return $this->sql;
    }

    /**
     * @return array
     */
    public function getBindings(): array
    {
        return $this->bindings;
    }

    /**
     * @return float
     */
    public function getTime(): float
    {
        return $this->time;
    }

    /**
     * @return string
     */
    public function getUniqueKey(): string
    {
        return md5($this->getFullQuery());
    }

    /**
     * @return string
     */
    public function getFullQuery(): string
    {
        return vsprintf(str_replace('?', "'%s'", $this->sql), $this->bindings);
    }
}
