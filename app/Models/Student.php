<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['matricule', 'surname', 'name', 'age', 'photo', 'promotion_id'];

    // Relation avec les classes via la table pivot student_classroom
    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'student_classroom')
            ->withPivot('start_date', 'end_date') // Inclure les dates de début et de fin
            ->withTimestamps();
    }

    // Récupérer la classe actuelle (celle sans end_date)
    public function currentClassroom()
    {
        return $this->classrooms()->wherePivot('end_date', null)->first();
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function notes()
    {
        return $this->hasMany(StudentEvaluation::class);
    }

    // Récupérer les notes pour une classe spécifique
    public function getNotesForClassroom($classroomId)
    {
        return $this->notes()->where('classroom_id', $classroomId)->get();
    }

    public function decisions()
    {
        return $this->hasMany(ConseilDecision::class);
    }

    public function calculerMoyenneGenerale()
    {
        return $this->notes()->avg('moyenne');
    }

    public function determinerRangClasse()
    {
        return $this->determinerRang($this->classe->etudiants());
    }

    public function determinerRangPromotion()
    {
        return $this->determinerRang($this->promotion->etudiants());
    }

    private function determinerRang($etudiants)
    {
        $moyennes = $etudiants->get()->map(function ($etudiant) {
            return [
                'id' => $etudiant->id,
                'moyenne' => $etudiant->calculerMoyenneGenerale()
            ];
        })->sortByDesc('moyenne');

        $rang = $moyennes->search(function ($item) {
                return $item['id'] === $this->id;
            }) + 1;

        return $rang;
    }

    public function mettreAJourRangs()
    {
        $this->rang_classe = $this->determinerRangClasse();
        $this->rang_promotion = $this->determinerRangPromotion();
        $this->save();
    }
}
