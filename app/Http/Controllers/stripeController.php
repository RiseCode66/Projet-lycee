<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\compaign;
use App\Models\contact;
use App\Models\contenue;
use App\Models\listOrder;
use App\Models\package;
use App\Models\pays;
use App\Models\User;
use App\Models\offre_pays;
use App\Models\order;
use App\Models\type_user;
use App\Rules\urlValidity;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;

class stripeController extends Controller
{
    public function index()
    {
        return view('stripe.index');
    }
    public function checkout(Request $req)
    {
        echo $req->input('id');
        $target = DB::table('listorder')->where('id',$req->input('id'))->get()->toArray();
        if(count($target)==0)
        {
            return back()->withErrors(['id not found']);
        }else
        {

            $validator=Validator::make($req->all(),[
                'id' => ['required', 'required'],
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            \Stripe\Stripe::setApiKey(Config('stripe.sk'));
            $session = \Stripe\Checkout\Session::create([
                    'line_items' => [
                        [
                            'price_data' => [
                                'currency' => 'eur',
                                'product_data' => [
                                    'name' => $target[0]->nomO,
                                ],
                                'unit_amount' => $target[0]->total*100,
                            ],
                            'quantity' => 1,
                        ],
                    ],
                    'mode' =>'payment',
                    'success_url' => route('success',['id'=>$target[0]->id]),
                ]);
            return redirect()->away($session->url);
        }

    }
    public function succes(Request $req)
    {
        $target = DB::table('orders')->where('id',$req->input('id'))->get()->toArray();
        if(count($target)==0)
        {
            return back()->withErrors(['Commande not found id='.$req->input('id')]);
        }else
        {
            $validator=Validator::make($req->all(),[
                'id'=>'required|numeric',
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $m=new order();
            $m->payement($req);
            return redirect('/formCompaign?id='.$req->input('id'));
        }
    }
}
