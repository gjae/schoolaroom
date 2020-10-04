<?php

namespace Database\Factories;

use App\Models\StudentInscription;
use App\Models\Student;
use App\Models\Period;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentInscriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StudentInscription::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'student_id' => Student::factory(),
            'period_id' => Period::factory(),
        ];
    }
}
