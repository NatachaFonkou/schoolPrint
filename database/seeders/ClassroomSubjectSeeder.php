<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassroomSubjectSeeder extends Seeder
{
    public function run()
    {
        DB::table('classroom_subject')->insert([
            'classroom_id' => 1,
            'subject_id' => 1,
        ]);

        DB::table('classroom_subject')->insert([
            'classroom_id' => 2,
            'subject_id' => 2,
        ]);
    }
}

