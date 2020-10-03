<?php

namespace Database\Factories;

use App\Models\Pensum;
use App\Models\Degree;
use Illuminate\Database\Eloquent\Factories\Factory;

class PensumFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pensum::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'degree_id' => Degree::factory(),
            'code' => $this->faker->numberBetween(5000000, 3000000),
            'is_active' => true,
            'is_current' => true
        ];
    }
}
