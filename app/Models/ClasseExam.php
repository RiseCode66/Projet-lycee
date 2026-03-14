<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClasseExam extends Model
{
    use HasFactory;

    protected $table = 'classe_exam';

    protected $fillable = [
        'idc',       // id de la classe
        'idex',      // id de l'examen
        'idm',       // id de la matière
        'date_debut',
        'date_fin',
        'nbr_sujets',
    ];

    public function classe()
    {
        return $this->belongsTo(Classe::class, 'idc');
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'idex');
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class, 'idm');
    }
}
