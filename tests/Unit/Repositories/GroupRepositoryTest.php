<?php

namespace Tests\Unit\Repositories;

use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Period;
use App\Models\Pensum;
use App\Models\StudentGroup;
use App\Repositories\GroupRepository;
use App\Models\CurricularUnit;

class GroupRepositoryTest extends TestCase
{

    use RefreshDatabase;

    private GroupRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = app(GroupRepository::class);
        Pensum::factory()->count(2)->create();
        Period::factory()->create();
    }

    /** @test */
    public function it_creates_new_group_without_period()
    {
        $this->expectErrorMessage('Period is missing on newGroup');

        $this->repository->newGroup('asdasdasdas', 'dasdasdasd', 35);
    }

    /** @test */
    public function it_create_new_group_on_set_period()
    {
        $period = Period::first();
        $pensum = Pensum::first();
        $this
            ->repository
            ->onPeriod($period)
            ->newGroup('330A', $pensum->id, 35);


        $this->assertDatabaseCount('student_groups', 1);
        $this->assertDatabaseHas('student_groups', ['max_quotas' => 35, 'pensum_id' => $pensum->id]);
    }

    /** @test */
    public function it_validates_new_group_creation_passing_period_has_newGroup_parameter()
    {
        $period = Period::first();
        $pensum = Pensum::first();
        $this
            ->repository
            ->newGroup('330A', $pensum->id, 35, $period->id);

        $this->assertDatabaseCount('student_groups', 1);
        $this->assertDatabaseHas('student_groups', ['max_quotas' => 35, 'pensum_id' => $pensum->id]);
    }

    /** @test */
    public function it_validates_group_update_via_update_repository_method()
    {
        $g = StudentGroup::factory()->create();

        $this->repository->findById($g->id)->update(['max_quotas' => 300]);

        $this->assertDatabaseHas('student_groups', ['id' => $g->id, 'max_quotas' => 300]);
    }

    /** @test */
    public function it_validates_that_group_can_created_timetable()
    {
        $group = StudentGroup::factory()->create();
        $uc = CurricularUnit::factory()->count(4)->create();
        
        $this
            ->repository
            ->setModel($group)
            ->schedule($uc->first()->id, '06:00', '08:00', 4)
            ->schedule($uc[1]->id, '08:15', '10:35', 5);

        $this->assertDatabaseCount('group_horary_matters', 2);
        $this->assertDatabaseHas('group_horary_matters', ['group_id' => $group->id]);
        $this->assertCount(2, StudentGroup::first()->horary);
    }

    /** @test */
    public function it_validates_time_schedule_exception_by_finish_time_is_before_than_init_time()
    {
        $this->expectException(Exception::class);

        $group = StudentGroup::factory()->create();
        $uc = CurricularUnit::factory()->count(4)->create();

        $this
            ->repository
            ->setModel($group)
            ->schedule($uc->first()->id, '08:00', '06:00', 4);

    }
}
