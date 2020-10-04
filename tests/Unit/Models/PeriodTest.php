<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Period;
use App\Models\Student;
use App\Models\Degree;
use App\Models\Pensum;

class PeriodTest extends TestCase
{
    use RefreshDatabase;

    private $period;

    public function setUp() : void
    {
        parent::setUp();
        $this->period = Period::factory()->create();
    }

    /** @test */
    public function it_validate_degree_model_returned()
    {
        $this->assertNotNull($this->period->degree);
        $this->assertInstanceOf(Degree::class, $this->period->degree);
    }

    /** @test */
    public function it_validate_pensum_model_returned()
    {
        $this->assertNotNull($this->period->pensum);
        $this->assertInstanceOf(Pensum::class, $this->period->pensum);
    }

    /** @test */
    public function it_validate_period_is_openned()
    {
        $period = Period::factory()->create();

        $this->assertTrue($period->is_opened);
    }

    /** @test */
    public function when_period_closed_is_not_null_then_period_is_closed()
    {
        $period = Period::factory()->create(['period_closed_at' => now()]);

        $this->assertNotNull($period->period_closed_at);
        $this->assertTrue($period->is_closed);
        $this->assertFalse($period->is_opened);
    }
}
