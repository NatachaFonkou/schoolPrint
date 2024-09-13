<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promotion;

class PromotionSeeder extends Seeder
{
    public function run()
    {
        Promotion::create(['name' => 'Promotion 2023']);
        Promotion::create(['name' => 'Promotion 2024']);
    }
}

