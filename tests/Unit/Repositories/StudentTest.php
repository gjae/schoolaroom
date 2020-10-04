<?php

namespace Tests\Unit\Repositories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Repositories\StudentRepository;
use App\Models\StudentInscription;
use App\Models\Student;
use App\Models\Period;

class StudentTest extends TestCase
{
    use RefreshDatabase;

    private $repository;

    public function setUp() : void
    {
        parent::setUp();
        $this->repository = app(StudentRepository::class);
    }

    /** @test */
    public function it_validate_that_student_already_enrollment_on_period()
    {
        StudentInscription::factory()->create();
        $period = Period::first();
        $student = Student::first();

        $this->assertTrue(
            $this->repository->findById($student->id)->enrollmentOn($period)
        );
        $this->assertTrue(
            $this->repository->enrollmentOn($period, $student->id)
        );
    }
}
