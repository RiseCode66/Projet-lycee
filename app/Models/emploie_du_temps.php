<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class emploie_du_temps extends Model
{
    use HasFactory;
    protected $table="emploie_du_temps";
    protected $fillable = [
        'idn',
        'idm',
        'jour',
        'heure',
    ];
    public function niveau()
    {
        return $this->belongsTo(niveau::class, 'idn');
    }
    public function matiere()
    {
        return $this->belongsTo(matiere::class, 'idm');
    }

    public function myItems($req)
    {
        $emp= $this::with('matiere')->where('idn','=',$req->input('id'))->orderBy('heure')->orderBy('jour')->get();
        $rs=[];
        foreach($emp as $e )
        {
            $rs[$e->heure][$e->jour]['idm']=$e->idm;
            $rs[$e->heure][$e->jour]['nom']=$e->nom;
        }
        return $rs;
    }

    public function saveMe($req)
    {
        $this->updateOrCreate(
            [
                'idn'=>$req->idn,
                'heure'=>$req->heure,
                'jour'=>$req->jour,
            ],[
                'idn'=>$req->idn,
                'idm'=>$req->idm,
                'heure'=>$req->heure,
                'jour'=>$req->jour,
            ]
            );
    }

    public function supr($req)
    {
        $eleve=emploie_du_temps::find($req->input('id'));
//        die;
        $eleve->delete();
    }
}
