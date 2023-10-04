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
        if ($this->isGreen()) {
            return '#5ab78c';
        }

        if ($this->totalTimeElapsedInMilliseconds() >= 1 && $this->totalTimeElapsedInMilliseconds() < 5) {
            return '#d99c45';
        }

        if ($this->totalTimeElapsedInMilliseconds() >= 5 && $this->totalTimeElapsedInMilliseconds() < 10) {
            return '#d88181';
        }

        return '#de4c60';
    }

    /**
     * @return bool
     */
    public function isGreen(): bool
    {
        return $this->totalTimeElapsedInMilliseconds() < 1;
    }

    /**
     * @return float
     */
    public function totalTimeElapsedInMilliseconds(): float
    {
        return round(($this->timeEnded - $this->timeStarted) * 1000, 2);
    }

    /**
     * @param ExestatCachedResult $result
     * @return float
     */
    public function getPadding(ExestatCachedResult $result): float
    {
        $percentage = $this->getPercentage($result);

        return max(5, (int)($percentage * 1.5));
    }

    /**
     * @param ExestatCachedResult $result
     * @return float
     */
    public function getPercentage(ExestatCachedResult $result): float
    {
        return round(($this->totalTimeElapsed / $result->getTotalTimeElapsed()) * 100, 2);
    }
}
