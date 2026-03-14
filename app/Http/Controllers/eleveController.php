<?php


namespace App\Http\Controllers;
use App\Models\eleve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\abs;
use App\Models\niveau;
use Illuminate\Validation\Rules;

class eleveController extends Controller
{
    public function index(Request $req){
        $e = new eleve();
        $filters = $req->only(['nom', 'prenom', 'nomN', 'dtn']);
        $myItems = $e->trimyItems($filters)->paginate(10)->appends($filters);
        //sleep(20);
        return view('component.HomeAdmin', compact('myItems', 'filters'));
    }
        public function formEleve(){
        return view('component.formEleve');
    }

    public function saveEleve(Request $req)
    {
        $montant=new eleve();
        $validator=Validator::make($req->all(),[
            'nom'=>'required|max:255',
            'prenom'=>'required|max:255',
            'dtn'=> 'date|required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $montant->saveMe($req);
        return redirect('/eleve');
    }

    public function saveAbs(Request $req)
    {
        $montant=new abs();
        $validator=Validator::make($req->all(),[
            'ide'=>'required|numeric',
            'dateDebut'=> 'date|required',
            'jours'=> 'required|numeric',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $montant->saveMe($req);
        return back();
    }
    public function formAddLevel(Request $req){
        $nv = DB::table('eleve')->where('id',$req->input('id'))->get()->toArray();
        if(count($nv)==0)
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
        $matiere = new niveau();
        $matie=$matiere->myItems();
        $myItems=[$matie,$req->input('id')];
        return view('component.formAddNiveau',compact('myItems'));
        }
    }

    public function saveLevel(Request $req)
    {
        $montant=new eleve();
        $validator=Validator::make($req->all(),[
            'id'=>'required|numeric',
            'idn'=>'required|numeric',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $montant->addLevel($req);
        return redirect('/eleve');
    }

    public function formModEleve(Request $req)
    {
        $myItems = DB::table('eleve')->where('id',$req->input('id'))->get()->toArray();
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
        return view('component.modEleve',compact('myItems'));
        }
    }
    public function modEleve(Request $req)
    {
        $montant=new eleve();
        $target = DB::table('eleve')->where('id',$req->input('id'))->get()->toArray();
        if(count($target)==0)
        {
            return back()->withErrors(['id not found']);
        }else
        {
            $validator=Validator::make($req->all(),[
                'id'=>'required|numeric',
                'nom'=>['required', 'string', 'max:255'],
                'prenom'=>['required', 'string', 'max:255'],
                'dtn'=>['required', 'date'],
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $montant->mod($req);
            return redirect('/eleve');
        }
    }
    public function supr(Request $req)
    {
        $package=new eleve();
        $target = DB::table('eleve')->where('id',$req->input('id'))->get()->toArray();
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
            return redirect('/eleve');
        }
    }
}
