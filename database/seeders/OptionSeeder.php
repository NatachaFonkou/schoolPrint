<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    public function run()
    {
        Option::create(['name' => 'Genie Informatique']);
        Option::create(['name' => 'Genie Civil']);
        Option::create(['name' => 'MSP']);
    }
}
