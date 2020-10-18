<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Pensum;
use App\Models\Degree;
use App\Models\CurricularUnit;
use App\Models\PensumHasSubject;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CurricularUnitTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_validate_if_matter_has_prelation()
    {
        Pensum::factory()->create();
        CurricularUnit::factory()->count(4)->create();
        $pensum = Pensum::first();
        $matters = CurricularUnit::all();
        PensumHasSubject::create([
            'pensum_id' => $pensum->id,
            'assignable_id' => $matters[0]->id,
            'assignable_type' => get_class($matters[0])
        ]);
        
        PensumHasSubject::create([
            'pensum_id' => $pensum->id,
            'assignable_id' => $matters[1]->id,
            'assignable_type' => get_class($matters[1]),
            'assignable_prelation_id' => $matters[0]->id,
            'assignable_prelation_type' => get_class($matters[0])
        ]);


        $this->assertNotNull($matters[0]->pensum);
        $this->assertInstanceOf(Pensum::class, $matters[0]->pensum);
        $this->assertTrue($pensum->is($matters[0]->pensum));
        // $this->assertTrue($matters[0]->prelateds()->first()->is($matters[1]));

    }

}
