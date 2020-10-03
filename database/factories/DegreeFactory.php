<?php

namespace Database\Factories;

use App\Models\Degree;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

class DegreeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Degree::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'degree' => $this->faker->firstNameMale,
            'degree_opened_at' => null,
            'mode' => Arr::random(['BIANNUAL', 'ANNUAL', 'QUARTERLY']),
        ];
    }
}
