<?php

namespace Database\Factories;

use App\Models\StudentInscriptionGroup;
use App\Models\StudentInscription;
use App\Models\GroupHoraryMatter;
use App\Models\StudentGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentInscriptionGroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StudentInscriptionGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'student_inscription_id' => StudentInscription::factory(),
            'student_group_id' => StudentGroup::factory(),
            'group_horary_matter_id' => GroupHoraryMatter::factory(),
        ];
    }
}
