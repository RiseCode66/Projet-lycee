<?php

namespace App\Http\Controllers;

use App\Models\contact;
use App\Models\contenue;
use App\Models\eleve;
use App\Models\listOrder;
use Illuminate\Http\Request;
use App\Models\package;
use App\Models\offre_pays;
use App\Models\order;
use App\Models\page;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class clientController extends Controller
{
    public function home(Request $req){
        $m=new eleve();
        $myItems=$m->myItems();
        return view('component.home',compact('myItems'));
    }
    //Commandes
    //contact
    public function formContact()
    {
        return view('component.formContact');
    }
    public function creerContact(Request $req)
    {
        $contact=new contact();
        $validator=Validator::make($req->all(),[
            'email'=>['required', 'string', 'lowercase', 'email', 'max:255'],
            'sujet'=>['required', 'string', 'max:255'],
            'message'=>['required', 'string','max:9999'],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $contact->saveMe($req);
        return redirect('/Contacts');
    }
    //About
    public function about()
    {
        $post=Post::all();
        return view('component.about',compact('post'));
    }
    //CMS
    public function page($req)
    {
        $p=new page();
        $page=$p->getPage($req);
        if(count($page)>0)
        {
            $myItem=$page[0];
            return view('component.Page',compact('myItem'));
        }else
        {
            return back()->withErrors(['Not found']);
        }
    }
}
