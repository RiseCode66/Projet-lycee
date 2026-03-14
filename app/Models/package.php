<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class package extends Model
{
    use HasFactory;
    protected $table='package';
    protected $fillable = [
        'id',
        'nom',
        'nombre',
    ];

    public function myItems()
    {
        return DB::select('select * from package order by nombre asc',);
    }

    public function saveMe($req)
    {
        $this->nom=$req->nom;
        $this->nombre=$req->nombre;
        $this->save();
    }
    public function findMe($id)
    {
        $Package=DB::select('select * from package where id = ?', [$id]);
        return $Package;
    }
    public function mod($req)
    {
        $package=package::find($req->input('id'));
        $package->nom=$req->input('nom');
        $package->nombre=$req->input('nombre');
        $package->update();
    }
    public function supr($req)
    {
        $package=package::find($req->input('id'));
        $package->delete();
    }
    public function recherche($req)
    {
        if($req->input('max')==0)
        {
            $db=DB::select("select max(nombre) as nbr from package");
            $max=$db[0]->nbr;
        }else
        {
            $max=$req->input('max');
        }
        $result=package::where('nom','like','%'.$req->input('nom').'%')
        ->where('nombre','>=',$req->input('min'))
        ->where('nombre','<=',$max)->get();
        $of=new offre_pays();
        $prix=$of->getByFind($req->input('nom'),$req->input('min'),$max);
        return [$result,$prix];
    }
}
