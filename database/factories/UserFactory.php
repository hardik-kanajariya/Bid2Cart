<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'country' => 'canada',
            'zip' => $this->faker->postcode(),
            'phone' => $this->faker->phoneNumber(),
            'ads' => '',
            'username' => $this->faker->unique()->userName(),
            'news_latter' => false,
            'status' => 'pending',
            'mail_hash' => Str::random(32),
            'google_id' => Str::random(32),
            'avatar' => $this->faker->imageUrl(640, 480, 'people', true, 'Faker'),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    public function bot()
    {
        return $this->state(function (array $attributes) {
            return [
                'first_name' => 'Bot ' . $this->faker->firstName(),
                'last_name' => $this->faker->lastName(),
                'email' => 'bot' . rand(1000, 9999) . '@bot.local',
            ];
        });
    }
}