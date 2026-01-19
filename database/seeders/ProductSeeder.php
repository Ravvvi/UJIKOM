<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    \App\Models\Product::create([
        'name' => 'Intel Core i9-13900K',
        'category' => 'Processor',
        'price' => 9500000,
        'stock' => 10,
        'description' => '24 Cores, 32 Threads, up to 5.8 GHz.',
    ]);

    \App\Models\Product::create([
        'name' => 'ASUS ROG Strix RTX 4090',
        'category' => 'VGA',
        'price' => 32000000,
        'stock' => 3,
        'description' => '24GB GDDR6X, DLSS 3, Ray Tracing.',
    ]);
}
}
