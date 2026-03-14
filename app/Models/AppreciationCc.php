<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AppreciationCc extends Model
{
    protected $table = 'appreciation_cc';
    protected $fillable = ['valeur', 'idp', 'ide'];

    public $timestamps = true;

    public static function getByPair($idp, $ide)
    {
        $a=AppreciationCc::where('idp', $idp)
        ->where('ide', $ide)
        ->first(); // ou ->get() si plusieurs résultats
        return  $a;
    }
            // Crée ou met à jour une appréciation selon idp et ide
    public static function createOrUpdateByPair($idp, $ide, $valeur)
    {
        $coefficient= new AppreciationCc();
        $coefficient->updateOrCreate(
            [
                'ide'=>$ide,
                'idp'=>$idp,
            ],
            [
                'ide'=>$ide,
                'idp'=>$idp,
                'valeur'=>$valeur,
            ]
            );
    }
}
