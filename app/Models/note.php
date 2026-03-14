<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class note extends Model
{
    use HasFactory;
    protected $table="note";
    protected $fillable = [
        'ide',
        'idex',
        'idm',
        'valeur'
    ];
    public function myItems()
    {
        return note::all();
    }
    public function findNote($req)
    {
        return DB::table('listnote')
        ->where('ide','=', $req->input('ide'))
        ->where('idex','=', $req->input('idex'))
        ->orderByDesc('coeff')
        ->get();
    }
    public function saveMe($req)
    {
        $coefficient= new note();
        $c=$coefficient->updateOrCreate(
            [
                'ide'=>$req->ide,
                'idex'=>$req->idex,
                'idm'=>$req->idm
            ],
            [
                'valeur'=>$req->valeur,
            ]
            );
/*        $this->ide=$req->ide;
        $this->idex=$req->idex;
        $this->idm=$req->idm;
        $this->valeur=$req->valeur;
        $this->save();*/
    }
    public function supr($id)
    {
        $target = DB::table(table: 'note')->where('id',$id);
        $target->delete();
    }
    public function suprEx($ide,$idex,$idm)
    {
        $target = DB::table(table: 'note')->where('idE','=',$ide)->where('idex','=',$idex)->where('idm','=',$idm);
        $target->delete();
    }
    public function mod($req)
    {
        $eleve=note::find($req->id);
        $eleve->ide=$req->ide;
        $eleve->idex=$req->idex;
        $eleve->idm=$req->idm;
        $eleve->valeur=$req->valeur;
//        die;
        $eleve->update();
    }
    public function reorder($tab)
    {
        for($i=0;$i<array_key_last($tab)+1;$i++)
        {
            if(array_key_exists($i,$tab))
            {

                for($j=0;$j<count($tab[$i]);$j++)
                {
                    if(str_contains($tab[$i][$j]['exam'],"DS1") & $tab[$i][$j]!=null)
                    {
                        $nt[$i][0]['nom']=$tab[$i][$j]['nom'];
                        $nt[$i][0]['id']=$tab[$i][$j]['id'];
                        $nt[$i][0]['valeur']=$tab[$i][$j]['valeur'];
                        $nt[$i][0]['exam']=$tab[$i][$j]['exam'];
                        $nt[$i][0]['coeff']=$tab[$i][$j]['coeff'];

                    }
                    if(str_contains($tab[$i][$j]['exam'],"DS2"))
                    {
                        $nt[$i][1]['nom']=$tab[$i][$j]['nom'];
                        $nt[$i][1]['id']=$tab[$i][$j]['id'];
                        $nt[$i][1]['valeur']=$tab[$i][$j]['valeur'];
                        $nt[$i][1]['exam']=$tab[$i][$j]['exam'];
                        $nt[$i][1]['coeff']=$tab[$i][$j]['coeff'];
                    }
                    if(str_contains($tab[$i][$j]['exam'],"examen"))
                    {
                        $nt[$i][2]['nom']=$tab[$i][$j]['nom'];
                        $nt[$i][2]['id']=$tab[$i][$j]['id'];
                        $nt[$i][2]['valeur']=$tab[$i][$j]['valeur'];
                        $nt[$i][2]['exam']=$tab[$i][$j]['exam'];
                        $nt[$i][2]['coeff']=$tab[$i][$j]['coeff'];
                    }
                    if(str_contains($tab[$i][$j]['exam'],"BAC BLANC "))
                    {
                        $nt[$i][2]['nom']=$tab[$i][$j]['nom'];
                        $nt[$i][2]['id']=$tab[$i][$j]['id'];
                        $nt[$i][2]['valeur']=$tab[$i][$j]['valeur'];
                        $nt[$i][2]['exam']=$tab[$i][$j]['exam'];
                        $nt[$i][2]['coeff']=$tab[$i][$j]['coeff'];
                    }
                    if(str_contains($tab[$i][$j]['exam'],"BREVET BLANC "))
                    {
                        $nt[$i][2]['nom']=$tab[$i][$j]['nom'];
                        $nt[$i][2]['id']=$tab[$i][$j]['id'];
                        $nt[$i][2]['valeur']=$tab[$i][$j]['valeur'];
                        $nt[$i][2]['exam']=$tab[$i][$j]['exam'];
                        $nt[$i][2]['coeff']=$tab[$i][$j]['coeff'];
                    }
    }
                ksort($nt[$i]);

            }
        }
        ksort($nt);

        return $nt;
    }
    public function getByPeriode($ide,$idp)
    {
        $e=new eleve();
        $eleve=$e->getEtu($ide);
        $m=new matiere();
        $matieres=$m->mesMatieres($eleve[0]->idn);
        $notes=DB::table('listnote')->join('exam','listnote.idex','=','exam.id')->where('ide','=',$ide)->where('exam.idp','=',$idp)->orderBy('nomM')->get();
        for($i=0;$i<count($matieres);$i++)
        {
            $k=0;
            for($j=0;$j<count($notes);$j++)
            {
                if($matieres[$i]->id==$notes[$j]->idm)
                {
                    $noteFinal[$i][$k]['nom']=$matieres[$i]->nom;
                    $noteFinal[$i][$k]['id']=$matieres[$i]->id;
                    $noteFinal[$i][$k]['valeur']=$notes[$j]->note;
                    $noteFinal[$i][$k]['exam']=$notes[$j]->nom;
                    $noteFinal[$i][$k]['coeff']=$notes[$j]->coeff;
                    $k=$k+1;
                }
            }
        }
        return $this->reorder($noteFinal);
    }
    public function mesNotesAnnuels($ida,$ide)
    {
        return DB::table('bulletin')
        ->join('periode', 'bulletin.idp', '=', 'periode.id')
        ->where('periode.ida', '=', $ida)
        ->where('bulletin.ide', '=', $ide)
        ->select(
            'bulletin.ide',
            'bulletin.nom',
            'bulletin.prenom',
            'bulletin.moyenne',
            'bulletin.idN',
            'bulletin.idp',
            'periode.nom as nom_periode'
        )
        ->get()
        ->toArray();
            }

}
