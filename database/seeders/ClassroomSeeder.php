<?php

namespace Database\Seeders;

use App\Models\Classroom;
use Illuminate\Database\Seeder;

class ClassroomSeeder extends Seeder
{
    public function run()
    {
        Classroom::create([
            'name' => 'Classroom A',
            'code' => 'CLSA',
            'option_id' => 1,
        ]);

        Classroom::create([
            'name' => 'Classroom B',
            'code' => 'CLSB',
            'option_id' => 2,
        ]);

        Classroom::create([
            'name' => 'Classroom C',
            'code' => 'CLSC',
            'option_id' => 2,
        ]);
    }
}
