<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\StudentInscription;
use App\Models\CurricularUnit;
use App\Models\StudentInscriptionGroup;
use App\Models\GroupHoraryMatter;
use App\Models\Student;

class StudentInscriptionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_validate_if_inscription_group_returned_inscription_relation_model()
    {
        $inscriptionGroup = StudentInscriptionGroup::factory()->create();
        $inscription = $inscriptionGroup->inscription;

        $this->assertNotNull($inscription);
        $this->assertInstanceOf(StudentInscription::class, $inscription);
    }

    /** @test */
    public function it_validate_matter_relationed_thorugh_between_inscription_and_inscription_group()
    {
        $inscription = StudentInscriptionGroup::factory()->create()->inscription;

        $this->assertNotNull($inscription->matters);
        $this->assertInstanceOf(Collection::class, $inscription->matters);
        $this->assertTrue(
            $inscription->matters->first()->is(CurricularUnit::first())
        );
    }

}
