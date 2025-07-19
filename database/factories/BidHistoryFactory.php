<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BidHistoryFactory extends Factory
{
    protected $model = \App\Models\BidHistory::class;

    public function definition()
    {
        return [
            'user_id' => rand(1, 70), // Will be updated in seeder
            'product_id' => rand(1, 100), // Will be updated in seeder
            'bidder' => $this->faker->userName(),
            'amount' => number_format(rand(10, 500), 2, '.', ''),
            'status' => $this->faker->randomElement(['active', 'outbid', 'winning']),
        ];
    }
}