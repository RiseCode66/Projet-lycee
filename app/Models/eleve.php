<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class eleve extends Model
{
    use HasFactory;
    protected $table="eleve";
    protected $fillable = [
        'nom',
        'prenom',
        'dtn',
    ];
    public function myItems()
    {
        return DB::table('info_etu_2')->orderBy('nom')->get();
    }
    public function trimyItems($filters = [])
    {
        $query = DB::table('info_etu_2');

        if (!empty($filters['nom'])) {
            $query->where('nom', 'like', '%' . $filters['nom'] . '%');
        }

        if (!empty($filters['prenom'])) {
            $query->where('prenom', 'like', '%' . $filters['prenom'] . '%');
        }

        if (!empty($filters['nomN'])) {
            $query->where('nomN', 'like', '%' . $filters['nomN'] . '%');
        }

        if (!empty($filters['dtn'])) {
            $query->whereDate('dtn', $filters['dtn']);
        }

        return $query->orderBy('id','desc');
    }
        public function getEtu($id)
    {
        $e=DB::table('info_etu')->where('id','=',$id) ->get();
        return $e;
    }
    public function saveMe($req)
    {
        $this->nom=$req->nom;
        $this->prenom=$req->prenom;
        $this->dtn=$req->dtn;
        $this->save();
    }
    public function supr($id)
    {
        $target = DB::table('eleve')->where('id',$id);
        $target->delete();
    }
    public function mod($req)
    {
        $eleve=eleve::find($req->input('id'));
        $eleve->nom=$req->input('nom');
        $eleve->prenom=$req->input('prenom');
        $eleve->dtn=$req->input('dtn');
//        die;
        $eleve->update();
    }
    public function addLevel($req)
    {
        $situation=new situation();
        $situation->idE=$req->id;
        $situation->idN=$req->idn;
        $situation->save();
    }
}
