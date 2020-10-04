<?php

namespace Tests\Unit\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use App\Models\Period;
use App\Models\Student;
use App\Models\GroupHoraryMatter;
use App\Models\PensumHasSubject;
use App\Models\StudentInscription;
use App\Services\Inscription;

class InscriptionTest extends TestCase
{
    use RefreshDatabase;

    private $service;

    public function setUp() : void
    {
        parent::setUp();
        $this->service = app(Inscription::class);
    }

    /** @test */
    public function it_validate_new_inscription()
    {
        $subject = PensumHasSubject::factory()->create();
        $period = Period::factory()->create();
        $student = Student::factory()->create();
        $pensum = $subject->pensum;
        $matter = $subject->subject;

        $this->service->newInscription($student->id, $period->id);

        $this->assertDatabaseHas('student_inscriptions', [
            'student_id' => $student->id, 'period_id' => $period->id
        ]);

    }

    /** @test */
    public function it_validate_that_student_cant_repeat_period_twice()
    {
        StudentInscription::factory()->create();
        $period = Period::first();
        $student = Student::first();

        $this->expectExceptionMessage("Student already enrollment on {$period->id} period");

        $this->service->newInscription($student->id, $period->id);

    }
    
}
