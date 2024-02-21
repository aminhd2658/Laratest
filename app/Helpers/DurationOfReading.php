<?php

namespace App\Helpers;

class DurationOfReading
{

    private $timePerWord = 1;
    private $wordLength;
    private $duration;

    public function __construct(private string $text)
    {
        $this->wordLength = count(explode(" ", $text));
        $this->duration = $this->wordLength * $this->timePerWord;
    }

    public function getTimePerSecond()
    {
        return $this->duration;
    }

    public function getTimePerMinute()
    {
        return $this->duration / 60;
    }
}
