<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\PeriodRepository;
use App\Models\Period;
use App\Models\Pensum;

class PeriodTest extends TestCase
{
    use RefreshDatabase;

    private $repository;

    public function setUp() : void
    {
        parent::setUp();
        $this->repository = app(PeriodRepository::class);
    }

    /** @test */
    public function model_instance_is_not_null()
    {
        $this->assertNotNull($this->repository->getModel());
    }

    /** @test */
    public function model_instance_should_be_period_instance()
    {
        $this->assertInstanceOf(Period::class, $this->repository->getModel());
    }

    /** @test */
    public function it_retrieve_openeds_periods()
    {
        Period::factory()->count(2)->create();

        $this->assertCount(2, $this->repository->getOpeneds());
    }

    /** @test */
    public function it_create_new_period()
    {
        $pensum = Pensum::factory()->create();
        $this->repository->newPeriod(
            $pensum->degree_id,
            $pensum->id,
            '32b3',
            false,
            now()->tomorrow()
        );
        $period = Period::first();

        $this->assertNotNull($period);
        $this->assertTrue($pensum->is($period->pensum));
        $this->assertTrue($pensum->degree->is($period->degree));
    }
}
