<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\exam;
use App\Models\periode;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\abs;
use App\Models\niveau;

class examController extends Controller
{
    //exam
    public function exam(Request $req)
    {
        $query = exam::query()
            ->select('exam.*', 'periode.nom as periode_nom')
            ->join('periode', 'exam.idp', '=', 'periode.id');

        // 🔍 Filtres
        if ($req->filled('nom')) {
            $query->where('exam.nom', 'like', '%' . $req->nom . '%');
        }
        if ($req->filled('idp')) {
            $query->where('exam.idp', $req->idp);
        }

        // 🔽 Tri
        $sort = $req->get('sort', 'exam.id');
        $order = $req->get('order', 'asc');
        $query->orderBy($sort, $order);

        // 📄 Pagination avec conservation des filtres
        $myItems = $query->paginate(10)->appends($req->all());

        // 📅 Liste des périodes pour les filtres / formulaires
        $periodes = periode::all();

        return view('component.exam', compact('myItems', 'periodes'));
    }
            public function examByEleve(Request $req){
        $e=new exam();
        $myItems=$e->myItems();
        return view('component.exam',compact('myItems'));
    }
    public function formExam(){
        $p=new periode();
        $myItems=$p->myItems();
        return view('component.formExam',compact('myItems'));
    }

    public function saveExam(Request $req)
    {
        $montant=new exam();
        $validator=Validator::make($req->all(),[
            'nom'=>'required|max:255',
            'idp'=>'required|numeric',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $montant->saveMe($req);
        return redirect('/exam');
    }

    public function formModExam(Request $req)
    {
        $myItems = DB::table('list_exam')->where('id',$req->input('id'))->get()->toArray();
        $p=new periode();
        $myItem=$p->myItems();
        if(count($myItems)==0)
        {
            return back()->withErrors(['id not found']);
        }else
        {
        $validator=Validator::make($req->all(),[
            'id'=>'required|numeric',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        return view('component.modExam',compact(['myItems','myItem']));
        }
    }
    public function modExam(Request $req)
    {
        $montant=new exam();
        $target = DB::table('list_exam')->where('id',$req->input('id'))->get()->toArray();
        if(count($target)==0)
        {
            return back()->withErrors(['id not found']);
        }else
        {
            $validator=Validator::make($req->all(),[
                'id'=>'required|numeric',
                'nom'=>['required', 'string', 'max:255'],
                'idp'=>'required|numeric',
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $montant->mod($req);
            return redirect('/exam');
        }
    }
    public function suprExam(Request $req)
    {
        $package=new exam();
        $target = DB::table('exam')->where('id',$req->input('id'))->get()->toArray();
        if(count($target)==0)
        {
            return back()->withErrors(['id not found']);
        }else
        {
            $validator=Validator::make($req->all(),[
                'id'=>'required|numeric',
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $package->supr($req->id);
            return redirect('/exam');
        }
    }
    public function details(Request $req)
    {
        $exam = exam::with(['classes', 'classes.eleves', 'classes.matiere'])->findOrFail($req->id);

        $planning = [];

        foreach ($exam->classes as $classe) {
            $pivot = $classe->pivot;
            $jour = date('Y-m-d', strtotime($pivot->date_debut));
            $heure = date('H:i', strtotime($pivot->date_debut));
            $planning[$classe->nom][$jour][$heure] = [
                'matiere' => $classe->matiere->nom,
                'nbr_sujets' => $pivot->nbr_sujets,
                'nbr_eleves' => $classe->eleves->count()
            ];
        }

        return view('component.examDetails', compact('exam', 'planning'));
    }
}
