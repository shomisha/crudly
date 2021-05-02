<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\Manufacturer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{
    protected $model = Car::class;

    public function definition()
    {
        return ['model' => $this->faker->text(255), 'manufacturer_id' => function ($arguments) {
            return Manufacturer::query()->inRandomOrder()->first()->id;
        }, 'production_year' => $this->faker->randomNumber(), 'first_registration_date' => $this->faker->date(), 'horse_power' => $this->faker->randomNumber()];
    }
}