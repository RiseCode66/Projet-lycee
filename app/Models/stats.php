<?php

namespace App\Models;

use App\Models\eleve;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class stats extends Model
{
    use HasFactory;
    protected $table="coefficient";
    protected $fillable = [
        'idm',
        'idn',
        'valeur',
    ];
    public function classement_etu_examen($idEX,$idN)
    {
        $resultats['results']=DB::table(table: 'moyenne_class_examen')->where('idEx','=',$idEX)->where('idN','=',$idN)->get()->toArray();
        $resultats['reussites']=0;
        $resultats['mention']['Passable']=0;
        $resultats['mention']['Assez Bien']=0;
        $resultats['mention']['Bien']=0;
        $resultats['mention']['Très Bien']=0;
        for($i=0;$i<count($resultats['results']);$i++)
        {
            if($resultats['results'][$i]->moyenne>9.99)
            {
                $resultats['reussites']+=1;
            }
            if($resultats['results'][$i]->moyenne>10 && $resultats['results'][$i]->moyenne<12)
            {
                $resultats['mention']['Passable']+=1;
            }
            if($resultats['results'][$i]->moyenne>11.99 && $resultats['results'][$i]->moyenne<14)
            {
                $resultats['mention']['Assez Bien']+=1;
            }
            if($resultats['results'][$i]->moyenne>13.99 && $resultats['results'][$i]->moyenne<16)
            {
                $resultats['mention']['Bien']+=1;
            }
            if($resultats['results'][$i]->moyenne>15.99)
            {
                $resultats['mention']['Très Bien']+=1;
            }
            $resultats['mention']['Échec']=count($resultats['results'])-$resultats['reussites'];
        }
        return $resultats;
    }
    public function classement_etu_periode($idp,$idN)
    {
        return DB::table(table: 'bulletin')->where('idp','=',$idp)->where('idN','=',$idN)->orderByDesc('moyenne') ->get();
    }
    public function getInfoPlus($idp, $ide, $ida)
    {
        // Sélection de l'idN (identifiant de la classe)
        $idN = DB::table('bulletin')->where('ide', $ide)->where('idp', $idp)->value('idN');

        // 1. Rang de l'élève dans la période
        $moyenne_eleve = DB::table('bulletin')
            ->where('ide', $ide)
            ->where('idp', $idp)
            ->value('moyenne');

        $rang = DB::table('bulletin')
            ->where('idp', $idp)
            ->where('idN', $idN)
            ->where('moyenne', '>', $moyenne_eleve)
            ->count();

            $info[0]=DB::select('select count(ide) as rang from bulletin where idp = '.$idp.' and idn = (select idN from bulletin where ide='.$ide.' and idp='.$idp.' ) and moyenne > (select moyenne from bulletin where ide='.$ide.' and idp='.$idp.') and (ide!='.$ide.')')[0];

        // 2. Moyenne de la classe
        $info[1] = DB::table('bulletin')
            ->where('idp', $idp)
            ->where('idN', $idN)
            ->selectRaw('AVG(moyenne) as moyenne')
            ->first();

        // 3. Rang général (moyenne annuelle)
        // Périodes de l’année
        $periodes = DB::table('periode')
            ->where('ida', $ida)
            ->pluck('id');

        // Moyenne annuelle de l'élève
        $moyennes_eleve = DB::table('bulletin')
            ->whereIn('idp', $periodes)
            ->where('ide', $ide)
            ->pluck('moyenne');

        $moyenne_annuelle_eleve = $moyennes_eleve->avg();

        // Moyennes annuelles des autres élèves de la même classe
        $autres_eleves = DB::table('bulletin')
            ->select('ide', DB::raw('AVG(moyenne) as moyenne_annuelle'))
            ->whereIn('idp', $periodes)
            ->where('idN', $idN)
            ->where('ide', '!=', $ide)
            ->groupBy('ide')
            ->get();

        // Calcul du rang annuel
        $rang_annuel = 1;
        foreach ($autres_eleves as $e) {
            if ($e->moyenne_annuelle > $moyenne_annuelle_eleve) {
                $rang_annuel++;
            }
        }

        $info[2] = ['rang_annuel' => $rang_annuel];

        return $info;
    }
}
