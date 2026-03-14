<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class niveau extends Model
{
    use HasFactory;
    protected $table="niveau";
    protected $fillable = [
        'nom',
    ];
    public function myItems()
    {
        return niveau::all();
    }

    public function saveMe($req)
    {
        $this->nom=$req->nom;
        $this->save();
    }
    public function supr($id)
    {
        $target = DB::table(table: 'niveau')->where('id',$id);
        $target->delete();
    }
    public function mod($req)
    {
        $eleve=niveau::find($req->input('id'));
        $eleve->nom=$req->input('nom');
        $eleve->update();
        $eleve2=niveau::find($req->input('id'));
    }
    public function mesProfs($id)
    {
        return DB::table(table: 'prof')
        ->join('assignation','assignation.idp','=','prof.id')
        ->where('idn','=',$id)
        ->get(['prof.id','prof.sign','assignation.idm']);
    }
    public function monProf($id)
    {
        return DB::table(table: 'prof')
        ->join('pp','pp.idp','=','prof.id')
        ->where('idn','=',$id)
        ->orderByDesc('pp.id')
        ->first(['prof.id','prof.nom','prof.sign']);
    }
    public function emploie_du_temps()
    {
        return $this->hasMany(emploie_du_temps::class, 'idn');
    }
}
