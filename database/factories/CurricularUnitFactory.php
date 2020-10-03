<?php

namespace Database\Factories;

use App\Models\CurricularUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

class CurricularUnitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CurricularUnit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(3, true),
            'code' => uniqid(),
            'credit_units' => 7
        ];
    }
}
