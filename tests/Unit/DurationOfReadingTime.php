<?php

namespace Tests\Unit;

use App\Helpers\DurationOfReading;
use PHPUnit\Framework\TestCase;

class DurationOfReadingTime extends TestCase
{

    public function testCanGetDurationOfReadingText(): void
    {
        // 1s per word
        $text = 'this is for test';
        $dor = new DurationOfReading($text);
        $this->assertEquals(4, $dor->getTimePerSecond());
        $this->assertEquals(4 / 60, $dor->getTimePerMinute());
    }
}
