<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class situation extends Model
{
    use HasFactory;
    protected $table="situation";
    protected $fillable = [
        'idE',
        'idN',
    ];
    public function myItems()
    {
        return situation::all();
    }

    public function saveMe($req)
    {
        $this->nom=$req->nom;
        $this->save();
    }
    public function supr($id)
    {
        $target = DB::table(table: 'situation')->where('id',$id);
        $target->delete();
    }
    public function mod($req)
    {
        $eleve=situation::find($req->input('id'));
        $eleve->nom=$req->input('nom');
//        die;
        $eleve->update();
    }
}
