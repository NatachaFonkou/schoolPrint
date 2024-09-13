<?php

namespace App\Console\Commands;

use App\Models\Student;
use Illuminate\Console\Command;

class MAJRangAutomatique extends Command
{
    protected $signature = 'etudiants:update-ranks';
    protected $description = 'Met à jour les rangs de tous les étudiants';

    public function handle()
    {
        Student::chunk(100, function ($etudiants) {
            foreach ($etudiants as $etudiant) {
                $etudiant->mettreAJourRangs();
            }
        });

        $this->info('Rangs des étudiants mis à jour avec succès.');
    }
}

