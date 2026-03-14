<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class annesco extends Model
{
    use HasFactory;
    protected $table="annesco";
    protected $fillable = [
        'nom',
    ];
    public function myItems()
    {
        return annesco::all();
    }

    public function saveMe($req)
    {
        $this->nom=$req->nom;
        $this->save();
    }
    public function supr($id)
    {
        $target = DB::table(table: 'annesco')->where('id',$id);
        $target->delete();
    }
    public function mod($req)
    {
        $eleve=annesco::find($req->input('id'));
        $eleve->nom=$req->input('nom');
        $eleve->update();
        $eleve2=annesco::find($req->input('id'));
    }
}
