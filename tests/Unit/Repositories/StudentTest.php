<?php

namespace Tests\Unit\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Repositories\StudentRepository;
use App\Models\StudentInscription;
use App\Models\Student;
use App\Models\Period;
use App\Models\GroupHoraryMatter;
use App\Models\StudentInscriptionGroup;

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

    /** @test */
    public function it_validate_find_inscription_by_period()
    {
        StudentInscription::factory()->create();
        $student = Student::latest()->first();
        $period = Period::latest()->first();
        $studentInscription = StudentInscription::latest()->first();

        $this->assertInstanceOf(
            StudentInscription::class, 
            $this
                ->repository
                ->setModel($student)
                ->findInscriptionByPeriod($period->id)
        );
        $this->assertTrue(
            $this
                ->repository
                ->setModel($student)
                ->findInscriptionByPeriod($period->id)
                ->is($studentInscription)
        );
    }

    /** @test */
    public function it_validate_find_group_by_inscription()
    {
        StudentInscriptionGroup::factory()->create();
        $student = Student::latest()->first();
        $inscription = StudentInscription::latest()->first();

        $this->repository->setModel($student);

        $this->assertCount(1, $this->repository->findGroupsByInscription($inscription->id));
        $this->assertNotNull(
            $this
                ->repository
                ->findGroupsByInscription($inscription->id)
                ->first()
                ->matter
        );
    }

    /** @test */
    public function it_alidate_find_groups_by_inscription_is_empty()
    {
        $student = Student::factory()->create();
        $inscription = StudentInscriptionGroup::factory()->create();
        $this->repository->setModel($student);

        $this->assertInstanceOf(
            Collection::class,
            $this->repository->findGroupsByInscription($inscription->id)
        );

        $this->assertCount(
            0,
            $this->repository->findGroupsByInscription($inscription->id)
        );
    }

    /** @test */
    public function it_validate_hour_crashed()
    {
        $studentInscription = StudentInscriptionGroup::factory()->create();
        $period = $studentInscription->inscription->period;
        $matter = GroupHoraryMatter::first();
        $student = Student::first();

        $matter = GroupHoraryMatter::factory()->create([
            'init_time' => $matter->init_time,
            'finish_time' => $matter->finish_time
        ]);


        $this->assertTrue(
            $this->repository->setModel($student)->isBusySchedule(
                $period,
                $matter->init_time->format('H:m'),
                $matter->finish_time->format('H:m')
            )
        );
    }

    /** @test */
    public function it_validate_that_hour_not_crashed()
    {

        $studentInscription = StudentInscriptionGroup::factory()->create();
        $period = $studentInscription->inscription->period;
        $matterTest = GroupHoraryMatter::first();
        $student = Student::first();
        $this->repository->setModel($student);

        $matter = GroupHoraryMatter::factory()->create([
            'init_time' => $matterTest->init_time->addHour(3),
            'finish_time' => $matterTest->finish_time->addHour(2)
        ]);


        $this->assertFalse(
            $this->repository->isBusySchedule(
                $period,
                $matter->init_time->subHour(4)->format('H:m'),
                $matter->finish_time->subHour(5)->format('H:m')
            )
        );

        $this->assertTrue(
            $this->repository->isBusySchedule(
                $period,
                $matter->init_time->format('H:m'),
                $matter->finish_time->format('H:m')
            )
        );

        // $this->assertFalse(
        //     $this->repository->isBusySchedule(
        //         $period,
        //         $matter->init_time->addHour(5)->format('H:m'),
        //         $matter->finish_time->addHour(6)->format('H:m')
        //     )
        // );
    }
}
