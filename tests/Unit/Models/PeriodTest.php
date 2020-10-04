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

    /** @test */
    public function it_retrieve_only_openeds_from_openeds_scope()
    {
        Period::factory()->count(2)->create();
        Period::factory()->count(7)->create(['period_closed_at' => now()]);

        $this->assertCount(3, Period::openeds()->get());
    }

    /** @test */
    public function it_retrieve_only_closed_periods_from_closeds_scope()
    {
        Period::factory()->count(3)->create(['period_closed_at' => now()]);

        $this->assertCount(3, Period::closeds()->get());
    }

    /** @test */
    public function it_mark_period_as_closed()
    {
        Period::factory()->create()->markAsClosed();
        Period::factory()->create()->markAsClosed(now()->yesterday());

        $this->assertCount(2, Period::closeds()->get());
    }
}
