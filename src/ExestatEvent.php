<?php

namespace Kbaas\Exestat;

class ExestatEvent
{
    /**
     * @var string
     */
    private string $title;

    /**
     * @var string|null
     */
    private ?string $description;

    /**
     * @var float
     */
    private float $timeStarted;

    /**
     * @var float|null
     */
    private ?float $timeEnded = null;

    /**
     * @var float|null
     */
    private ?float $totalTimeElapsed = null;

    /**
     * @var bool
     */
    private bool $isEvent;

    /**
     * @param string $title
     * @param string|null $description
     * @param bool $isEvent
     */
    public function __construct(string $title, ?string $description = null, bool $isEvent = false)
    {
        $this->title = $title;
        $this->timeStarted = microtime(true);
        $this->description = $description;
        $this->isEvent = $isEvent;
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

    /**
     * @return string
     */
    public function getColorCode(): string
    {
        // Green
        if ($this->isGreen()) {
            return '#5ab78c';
        }

        // Orange
        if ($this->getTotalTimeElapsedInMilliseconds() >= 1 && $this->getTotalTimeElapsedInMilliseconds() < 5) {
            return '#d99c45';
        }

        // Orange - Red
        if ($this->getTotalTimeElapsedInMilliseconds() >= 5 && $this->getTotalTimeElapsedInMilliseconds() < 10) {
            return '#f76f44';
        }

        // Red
        return '#ff0000';
    }

    /**
     * @return bool
     */
    public function isGreen(): bool
    {
        return $this->getTotalTimeElapsedInMilliseconds() < 1;
    }

    /**
     * @param int $precision
     * @return float
     */
    public function getTotalTimeElapsedInMilliseconds(int $precision = 2): float
    {
        return round(($this->timeEnded - $this->timeStarted) * 1000, $precision);
    }

    /**
     * @param ExestatCachedResult $result
     * @return float
     */
    public function getPercentage(ExestatCachedResult $result): float
    {
        return round(($this->totalTimeElapsed / $result->getTotalTimeElapsed()) * 100, 2);
    }

    /**
     * @return bool
     */
    public function isEvent(): bool
    {
        return $this->isEvent;
    }
}
