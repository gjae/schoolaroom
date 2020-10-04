<?php

namespace Database\Factories;

use App\Models\StudentGroup;
use App\Models\Period;
use App\Models\Pensum;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentGroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StudentGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $period = Period::factory()->create();
        return [
            'group' => $this->faker->numberBetween(100, 300),
            'max_quotas' => 25,
            'period_id' => $period->id,
            'pensum_id' => $period->pensum_id,
        ];
    }
}
