<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Pensum;
use App\Models\Degree;
use App\Models\CurricularUnit;
use App\Models\PensumHasSubject;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PensumTest extends TestCase
{
    use RefreshDatabase;

    private $pensum;

    public function setUp() : void
    {
        parent::setUp();
        $this->pensum = Pensum::factory()->create();
    }

    /** @test */
    public function it_validate_that_get_degree_retrieve_instance()
    {
        $this->assertNotNull($this->pensum->degree);
        $this->assertInstanceOf(Degree::class, $this->pensum->degree);
    }

    /** @test */
    public function it_retrieve_current_pensums()
    {
        $degree = Degree::factory()->create();
        Pensum::factory()->create(['degree_id' => $degree->id]);
        Pensum::factory()->count(2)->create([
            'degree_id' => $degree->id,
            'is_current' => false,
        ]);

        $this->assertCount(1, $degree->pensums);
        $this->assertCount(3, $degree->allPensums);
    }

}
