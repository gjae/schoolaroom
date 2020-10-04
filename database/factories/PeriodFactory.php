<?php

namespace Database\Factories;

use App\Models\Period;
use App\Models\Degree;
use App\Models\Pensum;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeriodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Period::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'degree_id' => Degree::factory(),
            'pensum_id' => Pensum::factory()->create()->id,
            'period_description' => $this->faker->words(3, true),
            'is_special' => false,
        ];
    }
}
