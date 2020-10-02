<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Student;
use APp\Models\People;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

class StudentTest extends TestCase
{
    use RefreshDatabase;

    private $student;

    public function setUp() : void
    {
        parent::setUp();
        $this->student = Student::factory()->create();
    }

    /** @test */
    public function it_verify_student_uuid_on_creating_model()
    {
        $this->assertNotNull($this->student);
        $this->assertInstanceOf(Student::class, $this->student);
        $this->assertTrue(Str::isUuid($this->student->id));
    }

    /** @test */
    public function it_verify_that_student_is_a_people()
    {
        $this->assertInstanceOf(People::class, $this->student->people);
    }
}
