<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class HelpersTest extends TestCase
{
    /** @test */
    public function it_test_time_between()
    {
        $this->assertTrue(\timeBetweenOr('22:00', '21:00', '00:00'));
        $this->assertTrue(\timeBetweenOr('2019-01-01 22:00', '2019-01-01 21:00', '2019-01-01 00:00'));
        $this->assertFalse(\timeBetweenOr('2019-01-01 22:00', '21:00', '00:00'));
    }
}
