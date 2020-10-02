<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\People;
use App\Models\Country;
use App\Models\State;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeopleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = People::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => (string) Str::uuid(),
            'first_name' => $this->faker->firstNameMale,
            'last_name' => $this->faker->lastName,
            'document_type' => Arr::random(['CI', 'P']),
            'document_id' => $this->faker->numberBetween(5000000, 3000000),
            'civil_state' => Arr::random(['SOLTERO/A', 'VIUDO/A', 'CASADO/A']),
            'sex' => Arr::random(['M', 'F', 'O']),
            'email' => $this->faker->unique()->email,
            'birthday_at' => $this->faker->date(),
            'country_id' => Country::factory(),
            'state_id' => State::factory(),
        ];
    }
}
