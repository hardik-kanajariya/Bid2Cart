<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = \App\Models\Product::class;

    private $productNames = [
        'Electronics' => [
            'Apple iPhone 14 Pro Max',
            'Samsung Galaxy S23 Ultra',
            'Sony WH-1000XM4 Headphones',
            'MacBook Pro 16-inch',
            'iPad Air 5th Generation',
            'Dell XPS 13 Laptop',
            'Nintendo Switch OLED',
            'AirPods Pro 2nd Generation',
            'Canon EOS R5 Camera',
            'LG OLED 55" TV'
        ],
        'Fashion' => [
            'Gucci Designer Handbag',
            'Rolex Submariner Watch',
            'Louis Vuitton Wallet',
            'Nike Air Jordan Sneakers',
            'Chanel Perfume Set',
            'Ray-Ban Aviator Sunglasses',
            'Hermès Silk Scarf',
            'Adidas Ultraboost Shoes',
            'Michael Kors Watch',
            'Coach Leather Jacket'
        ],
        'Home' => [
            'KitchenAid Stand Mixer',
            'Dyson V15 Vacuum Cleaner',
            'Nespresso Coffee Machine',
            'Le Creuset Dutch Oven',
            'Vitamix Professional Blender',
            'iRobot Roomba 980',
            'Instant Pot Duo Plus',
            'Shark Navigator Vacuum',
            'Cuisinart Food Processor',
            'Breville Espresso Machine'
        ]
    ];

    public function definition()
    {
        $categoryId = rand(1, 25);
        $categoryType = $categoryId <= 8 ? 'Electronics' : ($categoryId <= 16 ? 'Fashion' : 'Home');
        $productNames = $this->productNames[$categoryType];
        
        $retailValue = rand(50, 2000);
        $minimumBid = max(1, $retailValue * 0.1);
        $purchasePrice = $retailValue * 0.7;
        $currentBid = rand($minimumBid, $retailValue * 0.8);
        
        $images = [
            'https://picsum.photos/400/300?random=' . rand(1, 1000),
            'https://picsum.photos/400/300?random=' . rand(1001, 2000),
            'https://picsum.photos/400/300?random=' . rand(2001, 3000)
        ];

        return [
            'auction_id' => rand(1, 10), // Will be updated in seeder
            'category_id' => $categoryId,
            'brand_name' => $this->faker->randomElement(['Apple', 'Samsung', 'Sony', 'Nike', 'Gucci', 'Amazon', 'Microsoft', 'bid2cart']),
            'title' => $this->faker->randomElement($productNames),
            'thumbnail' => 'https://picsum.photos/300/300?random=' . rand(1, 1000),
            'images' => json_encode($images),
            'website' => $this->faker->url(),
            'condition_rating' => rand(6, 10),
            'condition_desc' => $this->faker->paragraph(3),
            'condition_note' => $this->faker->randomElement(['Excellent condition', 'Good condition', 'Fair condition', 'Like new', 'Minor wear', 'None']),
            'sku' => strtoupper($this->faker->unique()->bothify('??###??')),
            'minimum_bid' => number_format($minimumBid, 2, '.', ''),
            'purchase_price' => number_format($purchasePrice, 2, '.', ''),
            'retail_value' => number_format($retailValue, 2, '.', ''),
            'current_bid' => number_format($currentBid, 2, '.', ''),
            'auction_status' => $this->faker->randomElement(['active', 'pending', 'sold']),
            'start_time' => $this->faker->dateTimeBetween('-7 days', 'now')->format('Y-m-d H:i:s'),
            'end_time' => $this->faker->dateTimeBetween('now', '+7 days')->format('Y-m-d H:i:s'),
        ];
    }
}