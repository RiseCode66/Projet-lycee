<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class abs extends Model
{
    use HasFactory;
    protected $table="abs";
    protected $fillable = [
        'ide',
        'dateDebut',
        'jours',
        'raison',
    ];
    public function myItems()
    {
        return abs::all();
    }

    public function saveMe($req)
    {
        if(isset($req->raison))
        {
            $raison=$req->raison;
        }else{
            $raison="none";
        }
        $this->updateOrCreate(
            [
                'ide'=>$req->ide,
                'dateDebut'=>$req->dateDebut,
            ],[
                'ide'=>$req->ide,
                'dateDebut'=>$req->dateDebut,
                'jours'=>$req->jours,
                'raison'=>$raison,
            ]
            );
    }
    public function supr($req)
    {
        $eleve=abs::find($req->input('id'));
//        die;
        $eleve->delete();
    }
}
