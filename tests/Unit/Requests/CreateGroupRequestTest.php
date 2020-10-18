<?php

namespace Tests\Unit\Requests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CreateGroupRequest;
use App\Models\GroupHoraryMatter;

class CreateGroupRequestTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_valudates_horary_is_array()
    {
        $horary = GroupHoraryMatter::factory()->create();
        $horary = GroupHoraryMatter::first();
        
        $validation = $this->valid([
            'pensum_id' => $horary->group->pensum_id,
            'period_id' => $horary->group->period_id,
            'group_id' => $horary->group_id,
            'init_time' => '08:00',
            'finish_time' => '10:30',
            'group' => '330A',
            'max_quotas' => 35,
            'horary' => [
                []
            ]
        ]);

        $this->assertTrue($validation->fails());
    }

    /** @test */
    public function it_passes_validation()
    {

        $horary = GroupHoraryMatter::factory()->create();
        $horary = GroupHoraryMatter::first();
        
        $validation = $this->valid([
            'pensum_id' => $horary->group->pensum_id,
            'period_id' => $horary->group->period_id,
            'group_id' => $horary->group_id,
            'init_time' => '08:00',
            'finish_time' => '10:30',
            'group' => '330A',
            'max_quotas' => 35,
            'horary' => [
                [
                    'curricular_unit_id' => $horary->curricular_unit_id,
                    'init_time' => ['day' => 1, 'hour'=> '08:00'],
                    'finish_time' => ['day'=> 1, 'hour'=> '10:30']
                ]
            ]
        ]);

        $this->assertFalse($validation->fails());
    }

    private function valid($data = [])
    {
        $request = new CreateGroupRequest();        return Validator::make($data, $request->rules());
    }
}
