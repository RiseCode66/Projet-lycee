<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class coefficient extends Model
{
    use HasFactory;
    protected $table="coefficient";
    protected $fillable = [
        'idm',
        'idn',
        'valeur',
    ];
    public function myItems()
    {
        return matiere::all();
    }

    public function saveMe($req)
    {
        $this->idn=$req->id;
        $this->idm=$req->idm;
        $this->valeur=$req->valeur;
        $this->save();
    }
    public function choose($req)
    {
        $coefficient= new coefficient();
        $coefficient->updateOrCreate(
            [
                'idn'=>$req->input('id'),
                'idm'=>$req->input('idm')
            ],
            [
                'idn'=>$req->input('id'),
                'idm'=>$req->input('idm'),
                'valeur'=>$req->input('valeur'),
            ]
            );
    }
    public function supr($id)
    {
        $target = DB::table(table: 'coefficient')->where('id',$id);
        $target->delete();
    }
    public function mod($req)
    {
        $eleve=coefficient::find($req->input('id'));
        $eleve->idm=$req->idm;
        $eleve->idn=$req->idn;
        $eleve->valeur=$req->valeur;
//        die;
        $eleve->update();
    }
}
