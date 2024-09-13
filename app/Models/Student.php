<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['matricule', 'surname', 'name', 'age', 'photo', 'classroom_id', 'promotion_id'];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function notes()
    {
        return $this->hasMany(StudentEvaluation::class);
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
