<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class prof extends Model
{
    use HasFactory;
    protected $table="prof";
    protected $fillable = [
        'nom',
        'sign',
    ];
    public function myItems()
    {
        return prof::all()->sortBy('nom');
    }

    public function saveMe($req)
    {
        $this->nom=$req->nom;
        $this->sign=$req->sign;
        $this->save();
    }
    public function supr($id)
    {
        $target = DB::table(table: 'prof')->where('id',$id);
        $target->delete();
    }
    public function mod($req)
    {
        $eleve=prof::find($req->input('id'));
        $eleve->nom=$req->input('nom');
//        die;
        $eleve->update();
    }
    public function mesClasses($id)
    {
        return DB::table('assignation')
            ->join('matiere', 'matiere.id', '=', 'assignation.idm')
            ->join('niveau', 'niveau.id', '=', 'assignation.idn')
            ->where('idp', '=', $id)
            ->distinct()
            ->get(['assignation.idm','assignation.idn','matiere.nom as nomM','niveau.nom as nomN']);
    }
    public function emploieDuTemps($idp)
    {
        return DB::table('assignation')
            ->join('emploie_du_temps', function($join) {
                $join->on('assignation.idn', '=', 'emploie_du_temps.idn')
                     ->on('assignation.idm', '=', 'emploie_du_temps.idm');
            })
            ->where('assignation.idp', '=', $idp)
            ->distinct()
            ->get(['assignation.idm','assignation.idn','emploie_du_temps.jour','emploie_du_temps.heure']);
    }
        public function assigner($req)
    {
        DB::insert('insert into assignation( idp,idn,idm ) values ('.$req->idp.','.$req->idn.','.$req->idm.')');
    }
}
