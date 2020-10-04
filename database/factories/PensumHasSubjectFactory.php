<?php

namespace Database\Factories;

use App\Models\PensumHasSubject;
use App\Models\CurricularUnit;
use App\Models\Pensum;
use Illuminate\Database\Eloquent\Factories\Factory;

class PensumHasSubjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PensumHasSubject::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'assignable_id' => CurricularUnit::factory()->create()->id,
            'pensum_id' => Pensum::factory(),
            'assignable_type' => CurricularUnit::class,
        ];
    }
}
