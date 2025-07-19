<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class AuctionFactory extends Factory
{
    protected $model = \App\Models\Auction::class;

    public function definition()
    {
        $startDate = $this->faker->dateTimeBetween('-30 days', '+7 days');
        $endDate = (clone $startDate)->modify('+' . rand(1, 7) . ' days');
        
        return [
            'start_date' => $startDate->format('Y-m-d'),
            'start_time' => $startDate->format('H:i:s'),
            'end_date' => $endDate->format('Y-m-d'),
            'end_time' => $endDate->format('H:i:s'),
            'status' => $this->faker->randomElement(['active', 'pending', 'completed']),
        ];
    }

    public function active()
    {
        return $this->state(function (array $attributes) {
            $startDate = $this->faker->dateTimeBetween('-7 days', 'now');
            $endDate = $this->faker->dateTimeBetween('now', '+7 days');
            
            return [
                'start_date' => $startDate->format('Y-m-d'),
                'start_time' => $startDate->format('H:i:s'),
                'end_date' => $endDate->format('Y-m-d'),
                'end_time' => $endDate->format('H:i:s'),
                'status' => 'active',
            ];
        });
    }

    public function completed()
    {
        return $this->state(function (array $attributes) {
            $startDate = $this->faker->dateTimeBetween('-30 days', '-7 days');
            $endDate = $this->faker->dateTimeBetween('-7 days', '-1 day');
            
            return [
                'start_date' => $startDate->format('Y-m-d'),
                'start_time' => $startDate->format('H:i:s'),
                'end_date' => $endDate->format('Y-m-d'),
                'end_time' => $endDate->format('H:i:s'),
                'status' => 'completed',
            ];
        });
    }
}