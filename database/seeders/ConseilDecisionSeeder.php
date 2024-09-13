<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ConseilDecision;

class ConseilDecisionSeeder extends Seeder
{
    public function run()
    {
        ConseilDecision::create(['name' => 'Accepté']);
        ConseilDecision::create(['name' => 'Rejeté']);
    }
}
