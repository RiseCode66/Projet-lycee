<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class periode extends Model
{
    use HasFactory;
    protected $table="periode";
    protected $fillable = [
        'nom',
        'ida',
    ];
    public function myItems()
    {
        return periode::join('annesco','ida','=','annesco.id')->get(['periode.id as id','periode.nom as nom','ida','annesco.nom as nomA']);
    }

    public function saveMe($req)
    {
        $this->nom=$req->nom;
        $this->ida=$req->ida;
        $this->save();
    }
    public function supr($id)
    {
        $target = DB::table(table: 'periode')->where('id',$id);
        $target->delete();
    }
    public function mod($req)
    {
        $eleve=periode::find($req->input('id'));
        $eleve->nom=$req->input('nom');
        $eleve->ida=$req->input('ida');
//        die;
        $eleve->update();
    }
}
