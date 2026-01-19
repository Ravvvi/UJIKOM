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
        'name' => 'NVIDIA RTX 4060 Ti',
        'category' => 'VGA',
        'price' => 6500000,
        'stock' => 12,
        'description' => '8GB GDDR6, Dual Fan, Garansi Resmi.',
    ]);

    \App\Models\Product::create([
        'name' => 'AMD Ryzen 7 7800X3D',
        'category' => 'Processor',
        'price' => 7200000,
        'stock' => 8,
        'description' => 'Best gaming CPU, 8-Core, 16-Thread.',
    ]);
}
}
