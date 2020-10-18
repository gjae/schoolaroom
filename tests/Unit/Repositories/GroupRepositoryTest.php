<?php

namespace Tests\Unit\Repositories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Period;
use App\Models\Pensum;
use App\Models\StudentGroup;
use App\Repositories\GroupRepository;

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
}
