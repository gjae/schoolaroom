<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Degree;

class DegreeTest extends TestCase
{
    use RefreshDatabase;

    private $degree;

    public function setUp() : void
    {
        parent::setUp();
        $this->degree = Degree::factory()->create();
    }
    

    /** @test */
    public function it_validate_uuid_primary_key()
    {
        $this->assertNotNull($this->degree->id);
        $this->assertTrue(Str::isUuid($this->degree->id));
    }

    /** @test */
    public function it_validate_dependency_degree_relationship()
    {
        $anotherDegree = $this->degree->dependents()->save(
            Degree::factory()->create()
        );

        $this->assertNotNull($anotherDegree);
        $this->assertInstanceOf(Degree::class, $anotherDegree);
    }

    /** @test */
    public function it_validate_relationshops_methods_return()
    {
        $degree = Degree::factory()
                    ->create([
                        'degree_depends_id' => Degree::factory()->create()->id
                    ]);


        $this->assertDatabaseCount('degrees', 3);
        $this->assertNotNull($degree);
        $this->assertNotNull($degree->is_dependent);
    }

    /** @test */
    public function it_validate_relationship_ascendently_between_degrees()
    {
        $degree = Degree::factory()->create();
        $anotherDegree = Degree::factory()->create(['degree_depends_id' => $degree->id]);

        $this->assertTrue($anotherDegree->is_dependent->is($degree));
        $this->assertTrue($anotherDegree->hasDependencies());
        $this->assertFalse($degree->hasDependencies());
    }
}
