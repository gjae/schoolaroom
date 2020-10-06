<?php

namespace Tests\Unit\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\GroupHoraryMatter;

class GroupHoraryMatterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_validate_if_finish_time_and_init_time_is_carbon_instance()
    {
        $matter = GroupHoraryMatter::factory()->make();

        $this->assertInstanceOf(Carbon::class, $matter->init_time);
        $this->assertInstanceOf(Carbon::class, $matter->finish_time);
    }

}
