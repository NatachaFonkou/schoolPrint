<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;

class TeacherSeeder extends Seeder
{
    public function run()
    {
        Teacher::create([
            'name' => 'Mr. Albert Einstein',
            'email' => 'albert@einstein.com',
            'tel' => '123456789',
            'adresse' => '1 Science St'
        ]);

        Teacher::create([
            'name' => 'Mrs. Marie Curie',
            'email' => 'marie@curie.com',
            'tel' => '987654321',
            'adresse' => '2 Physics St'
        ]);
    }
}
