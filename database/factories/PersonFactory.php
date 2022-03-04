<?php

namespace Database\Factories;

use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Person::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => $this->faker->text(10),
            'name' => $this->faker->firstName($gender = null),
            'lastname' => $this->faker->lastName,
            'surname' => $this->faker->userName,
            'BirthDate' => $this->faker->date(),
            'passportInfo' => $this->faker->text(100),
            'address' => $this->faker->address,
            'addressReal' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'password' => $this->faker->password(6, 12),
            'checkIfSame' => $this->faker->boolean
        ];
    }
}
