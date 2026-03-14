<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class option extends Model
{
    use HasFactory;
    protected $table="option";
    protected $fillable = [
        'nom',
    ];
    public function myItems()
    {
        return option::all();
    }

    public function saveMe($req)
    {
        $this->nom=$req->nom;
        $this->save();
    }
    public function supr($id)
    {
        $target = DB::table(table: 'option')->where('id',$id);
        $target->delete();
    }
    public function mod($req)
    {
        $eleve=option::find($req->input('id'));
        $eleve->nom=$req->input('nom');
//        die;
        $eleve->update();
    }
}
