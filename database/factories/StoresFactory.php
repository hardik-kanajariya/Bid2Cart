<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StoresFactory extends Factory
{
    protected $model = \App\Models\Stores::class;

    public function definition()
    {
        return [
            'store_name' => $this->faker->company() . ' Auction House',
            'phone' => $this->faker->phoneNumber(),
            'street' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'pincode' => $this->faker->postcode(),
            'country' => 'canada',
            'status' => $this->faker->randomElement(['open', 'closed']),
        ];
    }
}