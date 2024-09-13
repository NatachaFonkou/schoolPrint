<?php

namespace App\Enums;

use Illuminate\Database\Eloquent\Model;

enum Semester : string
{
    case first_semester = 'Semestre 1';
    case second_semester = 'Semester 2';

    public static function currentSemester(): Semester
    {
        // Logique pour déterminer le semestre courant
        // Par exemple, en fonction du mois actuel, vous pouvez retourner le premier ou le deuxième semestre.
        $currentMonth = date('n');
        return $currentMonth <= 6 ? Semester::first_semester : Semester::second_semester;
    }
}
