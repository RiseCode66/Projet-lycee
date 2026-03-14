<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class exam extends Model
{
    use HasFactory;
    protected $table="exam";
    protected $fillable = [
        'nom',
        'idp',
    ];
    public function classes()
    {
        return $this->belongsToMany(
            niveau::class,
            'classe_exam',
            'idex',
            'idc'
        )->withPivot('idm', 'date_debut', 'date_fin', 'nbr_sujets')
         ->withTimestamps();
    }
        public function myItems()
    {
        return exam::all();
    }
    public function mesExams($req)
    {
        return DB::select('select * from list_exam where id in (select idex from listNote where idE=' .$req->input('id').')');
    }
    public function reorder($tab)
    {
        for($i=0;$i<count($tab);$i++)
        {
            if(str_contains($tab[$i]->nom,"DS1"))
            {
                $nt[0]['nom']=$tab[$i]->nom;
            }
            if(str_contains($tab[$i]->nom,"DS2"))
            {
                $nt[1]['nom']=$tab[$i]->nom;
            }
            if(str_contains($tab[$i]->nom,"examen"))
            {
                $nt[2]['nom']="examen";
            }
            if(str_contains($tab[$i]->nom,"BREVET BLANC"))
            {
                $nt[2]['nom']="examen";
            }
            if(str_contains($tab[$i]->nom,"BAC BLANC"))
            {
                $nt[2]['nom']="examen";
            }
        }
        ksort($nt);
        return $nt;
    }
    public function mesExamsParP($req)
    {
        $p=DB::select('select * from list_exam where id in (select idex from listNote where idE=' .$req->input('ide').') and idP='.$req->input('idp'));
        return $this->reorder($p);
    }
    public function mesPeriodes($req)
    {
        return DB::select('select * from periode  where id in (select idp from listNote join list_exam on list_exam.id=listNote.idex where idE=' .$req->input('id').')');
    }

    public function saveMe($req)
    {
        $this->nom=$req->nom;
        $this->idp=$req->idp;
        $this->save();
    }
    public function supr($id)
    {
        $target = DB::table(table: 'exam')->where('id',$id);
        $target->delete();
    }
    public function mod($req)
    {
        $eleve=exam::find($req->input('id'));
        $eleve->nom=$req->input('nom');
        $eleve->idp=$req->input('idp');
//        die;
        $eleve->update();
    }
}
