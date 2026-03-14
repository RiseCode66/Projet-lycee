<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class appreciation extends Model
{
    use HasFactory;
    protected $table="appreciation";
    protected $fillable = [
        'idm',
        'ide',
        'idp',
        'valeur',
    ];
    public function myItems()
    {
        return appreciation::all();
    }

    public function saveMe($req)
    {
        $this->updateOrCreate(
            [
                'idm'=>$req->idm,
                'ide'=>$req->ide,
                'idp'=>$req->idp,
            ],[
                'idm'=>$req->idm,
                'ide'=>$req->ide,
                'idp'=>$req->idp,
                'valeur'=>$req->valeur,
            ]
            );
        $this->idm=$req->idm;
        $this->ide=$req->ide;
        $this->idp=$req->idp;
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
    public function myApps($idp,$ide)
    {
        return appreciation::where('idp','=',$idp)->where('ide','=',$ide)->get();
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
