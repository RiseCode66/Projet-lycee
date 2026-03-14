<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class matiere extends Model
{
    use HasFactory;
    protected $table="matiere";
    protected $fillable = [
        'nom',
    ];
    public function myItems()
    {
        return matiere::orderBy('nom')->get();
    }

    public function saveMe($req)
    {
        $this->nom=$req->nom;
        $this->save();
    }
    public function supr($id)
    {
        $target = DB::table(table: 'matiere')->where('id',$id);
        $target->delete();
    }
    public function mod($req)
    {
        $eleve=matiere::find($req->input('id'));
        $eleve->nom=$req->input('nom');
//        die;
        $eleve->update();
    }
    public function mesMatieres($niveaux)
    {
        $m=DB::table('matiere_coeff')->where('idn','=',$niveaux)->orderByDesc('valeur')->orderBy('nom')->get();
        return $m;
    }
    public function assignerPP($req)
    {
        DB::insert('insert into pp( idp,idn ) values ('.$req->idp.','.$req->idn.')');
    }
}
