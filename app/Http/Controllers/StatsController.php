<?php

namespace App\Http\Controllers;

use App\Models\matiere;
use App\Models\exam;
use App\Models\periode;
use App\Models\niveau;
use App\Models\stats;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function get_dashboard(Request $req)
    {
        $ex = exam::all();
        $p = periode::all();
        $niveau = niveau::all();
        $matieres = matiere::all(); // si tu as un modèle Matiere, mets Matiere::all()

        $notes = collect(); // vide par défaut

        if ($req->idp && $req->idN) {

            // Si examen choisi
            if ($req->idEX) {
                $notes = DB::table('moyenne_class_examen')
                    ->where('idEx', $req->idEX)
                    ->where('idN', $req->idN);

                // Filtre matière
                if ($req->idM) {
                    $notes->where('idMatiere', $req->idM);
                }

                $notes = $notes->get();
            }
            else {
                // Période sans examen → bulletin
                $notes = DB::table('bulletin')
                    ->where('idp', $req->idp)
                    ->where('idN', $req->idN);

                if ($req->idM) {
                    $notes->where('idMatiere', $req->idM);
                }

                $notes = $notes->orderByDesc('moyenne')->get();
            }
        }

        return view('component.formC', compact('ex', 'p', 'niveau', 'matieres', 'notes'));
    }
    public function classement(Request $req)
    {
        // Charger données pour le formulaire
        $exam = new exam();
        $ex = $exam->myItems();
        $periode = new periode();
        $p = $periode->myItems();
        $n = new niveau();
        $niveau = $n->myItems();
        $m = new matiere();
        $stat = new stats();
        $matieres = Matiere::all();

        $resultats = null;
        $reussite = 0;
        $echec = 0;
        $mentions = [];
        $periode = null;
        $exam = null;
        $niveauS = null;
        $matiere = null;
        // Vérifier si le formulaire a été soumis
        if ($req->has('idp') && $req->has('idN')) {

            $periodeId = $req->idp;
            $niveauId  = $req->idN;
            $examId    = $req->idEX ?? null;
            $matiereId = $req->idM ?? null;
            if (!empty($matiereId)) {
                $query = DB::table('bulletinv2');
            }else{
                $query = DB::table('bulletin');
            }
            $query->where('idp', '=', $periodeId);
            $query->where('idN', '=', $niveauId);


            if (!empty($matiereId)) {
                $query->where('idM', '=', $matiereId);
            }

            $resultats = $query->orderByDesc('moyenne')->get();
            // Calcul réussite / échec
            $reussite = $resultats->where('moyenne', '>=', 10)->count();
            $echec = $resultats->where('moyenne', '<', 10)->count();
            // Mentions
            $mentions = [
                'Très Bien' => $resultats->where('moyenne', '>=', 16)->count(),
                'Bien'      => $resultats->whereBetween('moyenne', [14, 15.99])->count(),
                'Assez Bien'=> $resultats->whereBetween('moyenne', [12, 13.99])->count(),
                'Passable'  => $resultats->whereBetween('moyenne', [10, 11.99])->count(),
                'Échec'     => $resultats->where('moyenne', '<', 10)->count(),
            ];
            $resultats = $query->orderByDesc('moyenne')->get()->toArray();
            if (!empty($examId)) {
                $resultat=$stat->classement_etu_examen($examId,$niveauId);
                $resultats=$resultat['results'];
                $reussite=$resultat['reussites'];
                $echec=$resultat['mention']['Échec'];
                $mentions=$resultat['mention'];
            }

            $periode = periode::find($periodeId)->toArray();
            $niveauS = niveau::find($niveauId)->toArray();
            $exam = $examId ? Exam::find($examId) : null;
            $matiere = $matiereId ? Matiere::find($matiereId) : null;
        }

        return view('component.formC', compact(
            'ex', 'p', 'niveau', 'matieres',
            'resultats', 'reussite', 'echec', 'mentions',
            'periode', 'niveauS', 'exam', 'matiere'
        ));
    }
    }
