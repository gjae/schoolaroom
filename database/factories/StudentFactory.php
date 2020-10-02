<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\People;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'is_active' => true,
            'last_year_active' => now()->year,
            'people_id' => People::factory(),
        ];
    }
}
