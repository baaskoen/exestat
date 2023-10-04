<?php

namespace Kbaas\Exestat;

class ExestatEvent
{
    private string $title;

    private ?string $description;

    private float $timeStarted;

    private ?float $timeEnded = null;

    private ?float $totalTimeElapsed = null;

    /**
     * @param string $title
     * @param string|null $description
     */
    public function __construct(string $title, ?string $description = null)
    {
        $this->title = $title;
        $this->timeStarted = microtime(true);
        $this->description = $description;
    }

    /**
     * @return void
     */
    public function end(): void
    {
        $this->timeEnded = microtime(true);
        $this->totalTimeElapsed = ($this->timeEnded - $this->timeStarted);
    }

    /**
     * @return float
     */
    public function getDiffInNanoseconds(): float
    {
        return ($this->timeEnded - $this->timeStarted) * 1e9;
    }

    /**
     * @return float
     */
    public function getDiffInMilliseconds(): float
    {
        return ($this->timeEnded - $this->timeStarted) * 1000;
    }

    /**
     * @return float
     */
    public function getTimeStarted(): float
    {
        return $this->timeStarted;
    }

    /**
     * @return float|null
     */
    public function getTimeEnded(): ?float
    {
        return $this->timeEnded;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}
