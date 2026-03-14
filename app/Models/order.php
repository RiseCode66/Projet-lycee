<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class order extends Model
{
    use HasFactory;
    protected $table='orders';
    protected $fillable = [
        'id',
        'idPP',
        'idU',
        'status',
    ];
    public function getAll()
    {
        return DB::select('select * from listOrder ');
    }
    public function createorder($id)
    {
        $order=new order;
        $order->idPP=$id;
        $order->idU = Auth::id();
        $order->status=2;
        $order->created_at=Carbon::now();
        $order->save();
        $or=Db::select("select id from orders where idu=? and status=2 order by created_at desc limit 1 ",[Auth::id()]);
        return $or[0]->id;
    }
    public function supr($id)
    {
        $order=order::find($id);
        $order->delete();
    }
    public function payement($req)
    {
        $user=order::find($req->input('id'));
        $user->status=3;
        $user->updated_at=Carbon::now();
        $user->update(['timestamps' => false]);
    }

}
