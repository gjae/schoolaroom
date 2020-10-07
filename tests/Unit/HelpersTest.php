<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class HelpersTest extends TestCase
{
    /** @test */
    public function it_test_time_between_or()
    {
        $this->assertTrue(\timeBetweenOr('22:00', '21:00', '00:00'));
        $this->assertTrue(\timeBetweenOr('2019-01-01 22:00', '2019-01-01 21:00', '2019-01-01 00:00'));
        $this->assertFalse(\timeBetweenOr('2019-01-01 22:00', '21:00', '00:00'));
    }

    /** @test */
    public function it_test_time_between_and()
    {
        $this->assertTrue(\timeBetweenAnd('12:00', '11:00', '14:00'));
        $this->assertTrue(\timeBetweenAnd('13:30', '10:50', '16:15'));
    }
}
