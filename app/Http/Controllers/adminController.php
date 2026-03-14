<?php

namespace App\Http\Controllers;

use Illuminate\Support\MessageBag;

use App\Models\AppreciationCc;
use App\Models\appreciation;
use App\Models\coefficient;
use App\Models\annesco;
use App\Models\contenue;
use App\Models\emploie_du_temps;
use App\Models\exam;
use App\Models\matiere;
use App\Models\niveau;
use App\Models\note;
use App\Models\periode;
use App\Models\prof;
use App\Models\stats;
use Illuminate\Http\Request;
use App\Models\eleve;
use App\Models\User;
use League\Csv\Reader;
use App\Models\page;
use App\Models\type_user;
use App\Models\Post;
use App\Rules\urlValidity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use League\Csv\CharsetConverter;

class adminController extends Controller
{
    //eleve
    //exam
    public function exam(Request $req){
        $e=new exam();
        $myItems=$e->myItems();
        return view('component.exam',compact('myItems'));
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
    public function examEleve(Request $req){
        $nv = DB::table('info_etu')->where('id',$req->input('id'))->get()->toArray();
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
        $matiere = new exam();
        $matie=$matiere->mesExams($req);
        $periodes=$matiere->mesPeriodes($req);
        $myItems=[$matie,$req->input('id'),$periodes];
        $nv=$nv[0];
        return view('component.mesExam',compact(['myItems','nv']));
        }
    }

    //note
    public function note(Request $req){
        $e=new note();
        $eleve=new eleve();
        $myItems=[$eleve->getEtu($req->ide),$e->findNote($req),exam::find($req->idex)];
        return view('component.note',compact('myItems'));
    }
    public function notePeriode(Request $req){
        $e=new note();
        $eleve=new eleve();
        $eleve=$eleve->getEtu($req->ide);
        $p=new exam();
        $stat=new stats();
        $periode=periode::find($req->idp)->join('annesco','periode.ida','=','annesco.id')->where('periode.id','=',$req->idp) ->first(['periode.id as id','periode.nom as nom','ida','annesco.nom as nomA']);
        $ap=new appreciation();
        $appreciations=$ap->myApps($req->idp,$req->ide);
        $na=$e->mesNotesAnnuels($periode->ida,$req->ide);
        $n=new niveau();
        $sig=$n->mesProfs($eleve[0]->idn);
        $myItems=[$eleve,$e->getByPeriode($req->input('ide'),$req->input('idp')),$periode,$p->mesExamsParP($req),$stat->getInfoPlus($req->idp,$req->ide,$periode->ida),$appreciations,$na];
        $aps=new AppreciationCc();
        $myAps=$aps->getByPair($req->idp,$req->ide);
        return view('component.notePeriode',compact(['myItems','na','sig','myAps','periode']));
    }
    public function generateBulletinExamen(Request $req)
    {
        $e=new note();
        $eleve=new eleve();
        $eleve=$eleve->getEtu($req->ide);
        $exam=exam::find($req->idex);
        $myItems=[$eleve,$e->findNote($req)];

        // Charger la vue pour générer le PDF
        $pdf = PDF::loadView('component.bulletin_exam', compact('myItems'));

        // Télécharger le PDF
        return $pdf->download('bulletin_' . $eleve[0]->nom . '_' . $eleve[0]->prenom .'_'.$exam->nom .'.pdf');
    }
    public function generateBulletinPeriode(Request $req)
    {
        $e=new note();
        $eleve=new eleve();
        $eleve=$eleve->getEtu($req->ide);
        $p=new exam();
        $stat=new stats();
        $periode=periode::find($req->idp)->join('annesco','periode.ida','=','annesco.id')->where('periode.id','=',$req->idp) ->first(['periode.id as id','periode.nom as nom','ida','annesco.nom as nomA']);
        $ap=new appreciation();
        $appreciations=$ap->myApps($req->idp,$req->ide);
        $na=$e->mesNotesAnnuels($periode->ida,$req->ide);
        $myItems=[$eleve,$e->getByPeriode($req->input('ide'),$req->input('idp')),$periode,$p->mesExamsParP($req),$stat->getInfoPlus($req->idp,$req->ide,$periode->ida),$appreciations,$na];
        $n=new niveau();
        $p=$n->monProf($eleve[0]->idn);
        $sig=$n->mesProfs($eleve[0]->idn);

        // Charger la vue pour générer le PDF
/*        $pdf = PDF::loadView('component.bulletin_periode', compact('myItems'));

        // Télécharger le PDF
        return $pdf->download('bulletin_' . $eleve->nom . '_' . $eleve->prenom .'_'.$periode->nom .'.pdf');*/
        $aps=new AppreciationCc();
        $myAps=$aps->getByPair($req->idp,$req->ide);
        return view('component.bulletin_periode',compact(['myItems','na','sig','myAps','p']));

    }
    public function generateResultatExamPdf(Request $req)
        {
            $e=new stats();
            $myItems=[$e->classement_etu_examen($req->idex,$req->idn),exam::find($req->idex),$req->idn];
            $pdf = PDF::loadView('component.list_exam', compact('myItems'));
                // Télécharger le PDF
            return $pdf->download('list'.'.pdf');
        }
    public function formNote(Request $req){
        $e=new eleve();
        $m=new matiere();
        $ex=new exam();
        /*if($req->is('formNote'))
        {
            sleep(5);
        }*/
        $myItems=[$e->myItems(),$m->myItems(),$ex->myItems()];
        return view('component.formNote',compact('myItems'));
    }

    public function saveNote(Request $req)
    {
        $montant=new note();
        $validator=Validator::make($req->all(),[
            'ide'=>'required|numeric',
            'idex'=>'required|numeric',
            'idm'=>'required|numeric',
            'valeur'=>'required|numeric',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $montant->saveMe($req);
        return redirect('/formNote');
    }

    public function importNote(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');

        // Lire le contenu du CSV et forcer UTF-8 (Windows-1252 -> UTF-8 si Excel)
        $fileContent = file_get_contents($file->getRealPath());
        $fileContent = mb_convert_encoding($fileContent, 'UTF-8', 'Windows-1252');

        // Créer le CSV depuis la chaîne convertie
        $csv = Reader::createFromString($fileContent);
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();
        $errors = new MessageBag(); // MessageBag compatible Blade

        foreach ($records as $i => $record) {
            $ide = intval(str_replace('ELV00','',$record['matricule']));

            // Trouver la matière (en minuscules pour éviter problèmes d'accents)
            $matiere = Matiere::whereRaw('LOWER(nom) = ?', [mb_strtolower($record['matiere'], 'UTF-8')])->first();
            if (!$matiere) {
                $errors->add("Ligne ".($i+1), "Matière '{$record['matiere']}' non trouvée");
                continue;
            }

            // Trouver l'examen
            $examen = exam::whereRaw('LOWER(nom) = ?', [mb_strtolower($record['examen'], 'UTF-8')])->first();
            if (!$examen) {
                $errors->add("Ligne ".($i+1), "Examen '{$record['examen']}' non trouvé");
                continue;
            }

            $data = [
                'ide'   => $ide,
                'idm'   => $matiere->id,
                'idex'  => $examen->id,
                'valeur'=> floatval($record['valeur'])
            ];

            $validator = Validator::make($data, [
                'ide' => 'required|numeric',
                'idm' => 'required|numeric',
                'idex' => 'required|numeric',
                'valeur' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $msg) {
                    $errors->add("Ligne ".($i+1), $msg);
                }
                echo "Ligne ".($i+1).$msg;
                die;
                continue;
            }
            $note = new Note();
            $note->ide=$data['ide'];
            $note->idm=$data['idm'];
            $note->idex=$data['idex'];
            $note->valeur=$data['valeur'];
            $note->saveMe($note);
        }

        if ($errors->any()) {
            return back()->withErrors($errors)->with('success', 'Import partiel terminé avec des erreurs.');
        }

        return redirect('/formNote')->with('success', 'Toutes les notes ont été importées avec succès.');
    }
    public function suprNoteEx(Request $req)
    {
        $montant=new note();
        $validator=Validator::make($req->all(),[
            'ide'=>'required|numeric',
            'idex'=>'required|numeric',
            'idm'=>'required|numeric',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $montant->suprEx($req->ide,$req->idex,$req->idm);
        return back();
    }

    public function formModNote(Request $req)
    {
        $myItems = DB::table('note')->where('id',$req->input('id'))->get()->toArray();
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
        return view('component.modNote',compact('myItems'));
        }
    }
    public function modNote(Request $req)
    {
        $montant=new note();
        $target = DB::table('note')->where('id',$req->input('id'))->get()->toArray();
        if(count($target)==0)
        {
            return back()->withErrors(['id not found']);
        }else
        {
            $validator=Validator::make($req->all(),[
                'id'=>'required|numeric',
                'ide'=>'required|numeric',
                'idex'=>'required|numeric',
                'idm'=>'required|numeric',
                'valeur'=>'required|numeric',
                ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $montant->mod($req);
            return redirect('/note');
        }
    }
    public function suprNote(Request $req)
    {
        $package=new note();
        $target = DB::table('note')->where('id',$req->input('id'))->get()->toArray();
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
            return redirect('/note');
        }
    }
    public function modAppreciation(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'idp' => 'required|numeric',
            'ide' => 'required|numeric',
            'valeur' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $ac= new AppreciationCc();
        $ac->createOrUpdateByPair(
            $req->input('idp'),
            $req->input('ide'),
            $req->input('valeur')
        );

        return redirect()->back()->with('success', 'Appréciation enregistrée.');
    }
        //annesco
    public function annesco(Request $req){
        $e=new annesco();
        $myItems=$e->myItems();
        return view('component.annesco',compact('myItems'));
    }
    public function formAnnesco(){
        return view('component.formAnnesco');
    }

    public function saveAnnesco(Request $req)
    {
        $montant=new annesco();
        $validator=Validator::make($req->all(),[
            'nom'=>'required|max:255',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $montant->saveMe($req);
        return redirect('/annesco');
    }

    public function formModAnnesco(Request $req)
    {
        $myItems = DB::table('annesco')->where('id',$req->input('id'))->get()->toArray();
        $p=new annesco();
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
        return view('component.modAnnesco',compact(['myItems','myItem']));
        }
    }
    public function modAnnesco(Request $req)
    {
        $montant=new annesco();
        $target = DB::table('annesco')->where('id',$req->input('id'))->get()->toArray();
        if(count($target)==0)
        {
            return back()->withErrors(['id not found']);
        }else
        {
            $validator=Validator::make($req->all(),[
                'id'=>'required|numeric',
                'nom'=>['required', 'string', 'max:255'],
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $montant->mod($req);
            return redirect('/annesco');
        }
    }
    public function suprAnnesco(Request $req)
    {
        $package=new annesco();
        $target = DB::table('annesco')->where('id',$req->input('id'))->get()->toArray();
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
            return redirect('/annesco');
        }
    }
    //prof
    public function prof(Request $req)
    {
        $query = prof::query();

        // Filtre par nom si fourni
        if($req->filled('nom')){
            $query->where('nom', 'like', '%'.$req->nom.'%');
        }

        // Tri
        $sort = $req->get('sort', 'id');
        $order = $req->get('order', 'asc');
        $query->orderBy($sort, $order);

        // Pagination
        $myItems = $query->paginate(10)->appends($req->all());

        return view('component.prof', compact('myItems'));
    }
        public function formProf(){
        return view('component.formProf');
    }

    public function saveProf(Request $req)
    {
        $montant=new prof();
        $validator=Validator::make($req->all(),[
            'nom'=>'required|max:255',
            'sign'=>'required|image|mimes:jpeg,png,jpg|max:2028',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $path=$req->file('sign')->store('signatures','public');
        $req->sign=$path;
        $montant->saveMe($req);
        return redirect('/prof');
    }

    public function formModProf(Request $req)
    {
        $myItems = DB::table('prof')->where('id',$req->input('id'))->get()->toArray();
        $p=new prof();
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
        return view('component.modProf',compact(['myItems','myItem']));
        }
    }
    public function modProf(Request $req)
    {
        $montant=new prof();
        $target = DB::table('prof')->where('id',$req->input('id'))->get()->toArray();
        if(count($target)==0)
        {
            return back()->withErrors(['id not found']);
        }else
        {
            $validator=Validator::make($req->all(),[
                'id'=>'required|numeric',
                'nom'=>['required', 'string', 'max:255'],
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $montant->mod($req);
            return redirect('/prof');
        }
    }
    public function suprProf(Request $req)
    {
        $package=new prof();
        $target = DB::table('prof')->where('id',$req->input('id'))->get()->toArray();
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
            return redirect('/prof');
        }
    }
    public function mesClasses(Request $req)
    {
        $myItem = DB::table('prof')->where('id',$req->input('id'))->get()->toArray();
        $p=new prof();
        if(count($myItem)==0)
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
        $myItems=$p->mesClasses($req->input('id'));
        $emp=$p->emploieDuTemps($req->input('id'));
        $heure=["8h-9h","9h-10h","10h-10h30","10h30-11h30","11h30-13h30","13h30-14h","14h-14h30","14h30-15h","15h-16h"];
        $jour=["Lundi","Mardi","Mercredi","Jeudi","Vendredi"];
        $m=new matiere();
        $classe=niveau::all();
        $matieres=$m->myItems();
        return view('component.classeP',compact(['myItem','myItems','classe','matieres','emp','heure','jour']));
        }
    }
    public function assignerProf(Request $req)
    {
        $montant=new prof();
        $validator=Validator::make($req->all(),[
            'idp'=>'required|numeric',
            'idm'=>'required|numeric',
            'idn'=>'required|numeric',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $montant->assigner($req);
        return back();
    }
    public function assignerPP(Request $req)
    {
        $montant=new matiere();
        $validator=Validator::make($req->all(),[
            'idp'=>'required|numeric',
            'idn'=>'required|numeric',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $montant->assignerPP($req);
        return back();
    }
    public function suprAss(Request $req)
    {
        $package=new prof();
        $target = DB::table('assignation')->where('id',$req->input('id'))->get()->toArray();
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
            $target[0]->delete();
            return back();
        }
    }
    //classement
    public function get_classement_examen(){
        $ex= exam::all();
        $p=periode::all();
        $niveau=niveau::all();
        return view('component.formC2',compact(['ex','niveau','p']));
    }
    public function classement_examen(Request $req){
        $e=new stats();
        $myItems=[$e->classement_etu_examen($req->idEX,$req->idN),exam::find($req->idEX),$req->idN,niveau::find($req->idN)];
        return view('component.classement_examen',compact('myItems'));
    }
    public function classement_periode(Request $req){
        $e=new stats();
        $myItems=[$e->classement_etu_periode($req->idp,$req->idN),periode::find($req->idp)];
        return view('component.classement_periode',compact('myItems'));
    }
    //appreciat
    public function saveImp(Request $req)
    {
        $montant=new appreciation();
        $validator=Validator::make($req->all(),[
            'ide'=>'required|numeric',
            'idp'=>'required|numeric',
            'idm'=>'required|numeric',
            'valeur'=>'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $montant->saveMe($req);
        return back();
    }
    //niveau
    public function niveaux(Request $req)
    {
        $query = niveau::query();

        // Filtre par nom si fourni
        if($req->filled('nom')){
            $query->where('nom', 'like', '%'.$req->nom.'%');
        }

        // Tri
        $sort = $req->get('sort', 'id');
        $order = $req->get('order', 'asc');
        $query->orderBy($sort, $order);

        // Pagination
        $myItems = $query->paginate(10)->appends($req->all());

        return view('component.Niveaux', compact('myItems'));
    }
        public function formNiveau(){
        return view('component.formNiveau');
    }

    public function saveNiveau(Request $req)
    {
        $montant=new niveau();
        $validator=Validator::make($req->all(),[
            'nom'=>'required|max:255',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $montant->saveMe($req);
        return redirect('/niveau');
    }

    public function formModNiveau(Request $req)
    {
        $myItems = DB::table('niveau')->where('id',$req->input('id'))->get()->toArray();
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
        return view('component.modNiveau',compact('myItems'));
        }
    }
    public function modNiveau(Request $req)
    {
        $montant=new niveau();
        $target = DB::table('niveau')->where('id',$req->input('id'))->get()->toArray();
        if(count($target)==0)
        {
            return back()->withErrors(['id not found']);
        }else
        {
            $validator=Validator::make($req->all(),[
                'id'=>'required|numeric',
                'nom'=>['required', 'string', 'max:255'],
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $montant->mod($req);
            return redirect('/niveau');
        }
    }
    public function suprNiveau(Request $req)
    {
        $package=new niveau();
        $target = DB::table('niveau')->where('id',$req->input('id'))->get()->toArray();
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
            return redirect('/niveau');
        }
    }
    public function getMatiere(Request $req)
    {
        $package=new niveau();
        $target = DB::table('niveau')->where('id',$req->input('id'))->get()->toArray();
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
            $e=new matiere();
            $myItems=$e->mesMatieres($req->input('id'));
            return view('component.Niveaux',compact('myItems'));
        }
    }
    public function formNiveauxMatieres(Request $req){
        $nv = DB::table('niveau')->where('id',$req->input('id'))->get()->toArray();
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
        $matiere = new matiere();
        $matie=$matiere->myItems();
        $myItems=[$matie,$req->input('id')];
        return view('component.formAddMatiere',compact('myItems'));
        }
    }
    public function saveCoefficient(Request $req)
    {
        $coefficient=new coefficient();
        $validator=Validator::make($req->all(),[
            'id'=>'required|numeric',
            'idm'=>'required|numeric',
            'valeur'=>'required|numeric',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $coefficient->choose($req);
        return redirect('/niveau');
    }
    public function saveEmp(Request $req)
    {
        $emploie_du_temps=new emploie_du_temps();
        $validator=Validator::make($req->all(),[
            'idn'=>'required|numeric',
            'idm'=>'required|numeric',
            'jour'=>'required|numeric|max:5',
            'heure'=>'required|numeric|max:8',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $emploie_du_temps->saveMe($req);
        return back();
    }
    public function mesMatieres(Request $req)
    {
        $nv = DB::table('niveau')->where('id',$req->input('id'))->get()->toArray();
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
        $prof= new prof();
        $profs= $prof->myItems();
        $matiere = new matiere();
        $n=new niveau();
        $heure=["8h-9h","9h-10h","10h-10h30","10h30-11h30","11h30-13h30","13h30-14h","14h-14h30","14h30-15h","15h-16h"];
        $nv= niveau::find($req->input('id'));
        $emp=new emploie_du_temps();
        $emp=$emp->myItems($req);
        $p=$n->monProf($req->input('id'));
        $matie=$matiere->mesMatieres($req->input('id'));
        $myItems=$matie;
        return view('component.mesMatiere',compact(['myItems','profs','p','nv','emp','heure']));
    }
    }
    //periode
    public function periode()
    {
        $periode=new periode();
        $myItems=$periode->myItems();
        return view('component.periode',compact('myItems'));
    }
    public function formPeriode(){
        $periode=new annesco();
        $myItems=$periode->myItems();
        return view('component.formPeriode',compact('myItems'));
    }

    public function savePeriode(Request $req)
    {
        $montant=new periode();
        $validator=Validator::make($req->all(),[
            'nom'=>'required|max:255',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $montant->saveMe($req);
        return redirect('/periode');
    }

    public function formModPeriode(Request $req)
    {
        $myItems = DB::table('periode')->where('id',$req->input('id'))->get()->toArray();
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
        $a=new annesco();
        $annesco=$a->myItems();
        return view('component.modPeriode',compact(['myItems','annesco']));
        }
    }
    public function modPeriode(Request $req)
    {
        $montant=new periode();
        $target = DB::table('periode')->where('id',$req->input('id'))->get()->toArray();
        if(count($target)==0)
        {
            return back()->withErrors(['id not found']);
        }else
        {
            $validator=Validator::make($req->all(),[
                'id'=>'required|numeric',
                'nom'=>['required', 'string', 'max:255'],
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $montant->mod($req);
            return redirect('/periode');
        }
    }
    public function suprPeriode(Request $req)
    {
        $package=new periode();
        $target = DB::table('periode')->where('id',$req->input('id'))->get()->toArray();
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
            return redirect('/periode');
        }
    }

    //matiere
    public function matiere(Request $req){
        $e=new matiere();
        $myItems=$e->myItems();
        return view('component.matiere',compact('myItems'));
    }
    public function formMatiere(){
        return view('component.formMatiere');
    }

    public function saveMatiere(Request $req)
    {
        $montant=new matiere();
        $validator=Validator::make($req->all(),[
            'nom'=>'required|max:255',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $montant->saveMe($req);
        return redirect('/Matiere');
    }

    public function formModMatiere(Request $req)
    {
        $myItems = DB::table('matiere')->where('id',$req->input('id'))->get()->toArray();
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
        return view('component.modMatiere',compact('myItems'));
        }
    }
    public function modMatiere(Request $req)
    {
        $montant=new matiere();
        $target = DB::table('Matiere')->where('id',$req->input('id'))->get()->toArray();
        if(count($target)==0)
        {
            return back()->withErrors(['id not found']);
        }else
        {
            $validator=Validator::make($req->all(),[
                'id'=>'required|numeric',
                'nom'=>['required', 'string', 'max:255'],
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $montant->mod($req);
            return redirect('/Matiere');
        }
    }
    public function suprMatiere(Request $req)
    {
        $package=new matiere();
        $target = DB::table('Matiere')->where('id',$req->input('id'))->get()->toArray();
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
            return redirect('/Matiere');
        }
    }
    //user
    public function user()
    {
        $m=new user();
        $myItems=[$m->getAll(),type_user::all()];
        return view('component.Users',compact('myItems'));
    }
    public function suprUser(Request $req)
    {
        $target = DB::table('users')->where('id',$req->input('id'))->get()->toArray();
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
            $user=new User();
            $user->supr($req->input('id'));
            return redirect('/user');
        }
    }
    public function formModUser(Request $req)
    {
        $target = DB::table('users')->where('id',$req->input('id'))->get()->toArray();
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
            $myItems=[User::find($req->input('id')),type_user::all()];
            return view('component.modUser',compact('myItems'));
        }
    }
    public function formModMyUser(Request $req)
    {
        $target = DB::table('users')->where('id',$req->input('id'))->get()->toArray();
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
            $myItems=[User::find($req->input('id')),type_user::all()];
            return view('component.modMyInfo',compact('myItems'));
        }
    }
    public function modUser(Request $req)
    {
        $target = DB::table('users')->where('id',$req->input('id'))->get()->toArray();
        if(count($target)==0)
        {
            return back()->withErrors(['id not found']);
        }else
        {

            $user=new user();
            $validator=Validator::make($req->all(),[
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
                'type_user' => ['required', 'numeric'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $user->mod($req);
            return redirect('/user');
        }
    }
    public function modMyUser(Request $req)
    {
        if($req->input('id')!=Auth::id())
        {
            return back()->withErrors(['Not Allowed']);
        }
        $target = DB::table('users')->where('id',$req->input('id'))->get()->toArray();
        if(count($target)==0)
        {
            return back()->withErrors(['id not found']);
        }else
        {

            $user=new user();
            $validator=Validator::make($req->all(),[
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $user->myMod($req);
            return redirect('/');
        }
    }

    //contenue
    public function listContenue(){
        $m=new contenue();
        $myItems=$m->myItems();
        return view('component.listContenue',compact('myItems'));
    }
    public function formContenue(){
        return view('component.InsertContenue');
    }

    public function saveContenue(Request $req)
    {
        $montant=new contenue();
        $validator=Validator::make($req->all(),[
            'titre'=>'required|max:255',
            'description'=>'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $montant->saveMe($req);
        return redirect('/listContenue');
    }
    public function suprContenue(Request $req)
    {
        $target = DB::table('contenue')->where('id',$req->input('id'))->get()->toArray();
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
            $contact=new contenue();
            $contact->supr($req->input('id'));
            return redirect('listContenue');
        }
    }
    public function formModContenue(Request $req)
    {
        $target = DB::table('contenue')->where('id',$req->input('id'))->get()->toArray();
        if(count($target)==0)
        {
            return back()->withErrors(['id not found']);
        }else
        {

            $user=new user();
            $validator=Validator::make($req->all(),[
                'id' => ['required', 'required'],
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $myItems=contenue::find($req->input('id'));
            return view('component.modContenue',compact('myItems'));
        }
    }
    public function modContenue(Request $req)
    {
        $target = DB::table('contenue')->where('id',$req->input('id'))->get()->toArray();
        if(count($target)==0)
        {
            return back()->withErrors(['id not found']);
        }else
        {
            $validator=Validator::make($req->all(),[
                'id'=>'required|numeric',
                'titre'=>'required|max:255',
                'description'=>'required',
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $montant=new contenue();
            $montant->mod($req);
            return redirect('/listContenue');
        }
    }
    //about
    public function formAbout()
    {
        $post=Post::all();
        return view('component.AboutMake',compact('post'));
    }
    public function store(Request $req)
    {
        $validator=Validator::make($req->all(),[
            'title'=>'required|max:255',
            'post-trixFields'=>'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $post = new Post();
        $post->title=$req->input('title');
        $post->content=$req->input('post-trixFields')['content'];
        $post->save();

        return redirect('/formAbout');
    }
    public function deleteAbout(Request $req)
    {
        $validator=Validator::make($req->all(),[
            'id'=>'required|numeric',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $about=Post::find($req->input('id'));
        if($about==null)
        {
            return back()->withErrors(['id not found']);
        }else
        {
            $about->delete();
            return redirect('/formAbout');
        }
    }
//cms
    public function formCMS()
    {
        return view('component.formCMS');
    }
    public function storeCMS(Request $req)
    {
        $validator=Validator::make($req->all(),[
            'title'=>'required|max:255',
            'slug'=>'required|max:255',
            'post-trixFields'=>'required',
            'afficher'=>'required|numeric',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $post = new page();
        $post->title=$req->input('title');
        $post->slug=$req->input('slug');
        $post->content=$req->input('post-trixFields')['content'];
        $post->afficher=$req->input('afficher');
        $post->save();
        return redirect('/formCMS');
    }
    public function cms()
    {
        $myItems=page::all();
        return view('component.listCMS',compact('myItems'));

    }
    public function deleteCMS(Request $req)
    {
        $validator=Validator::make($req->all(),[
            'id'=>'required|numeric',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $about=page::find($req->input('id'));
        if($about==null)
        {
            return back()->withErrors(['id not found']);
        }else
        {
            $about->delete();
            return redirect('/cms');
        }
    }
    public function formModCMS(Request $req)
    {
        $validator=Validator::make($req->all(),[
            'id'=>'required|numeric',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $myItems=page::find($req->input('id'));
        if($myItems==null)
        {
            return back()->withErrors(['id not found']);
        }else
        {
            return view('component.formModCMS',compact('myItems'));
        }
    }
    public function modCMS(Request $req)
    {
        $validator=Validator::make($req->all(),[
            'id'=>'required|numeric',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $page=page::find($req->input('id'));
        if($page==null)
        {
            return back()->withErrors(['id not found']);
        }else
        {
            $page->title=$req->input('title');
            $page->slug=$req->input('slug');
            $page->content=$req->input('content');
            $page->afficher=$req->input('afficher');
            $page->update();
            return redirect('/cms');
        }
    }
}

