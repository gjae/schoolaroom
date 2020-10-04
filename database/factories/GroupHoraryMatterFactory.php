<?php

namespace Database\Factories;

use App\Models\GroupHoraryMatter;
use App\Models\CurricularUnit;
use App\Models\StudentGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupHoraryMatterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GroupHoraryMatter::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'group_id' => StudentGroup::factory(),
            'curricular_unit_id' => CurricularUnit::factory(),
            'init_time' => '10:30',
            'finish_time' => '12:15',
        ];
    }
}
