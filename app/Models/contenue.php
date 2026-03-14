<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class contenue extends Model
{
    use HasFactory;
    protected $table="contenue";
    protected $fillable = [
        'id',
        'Titre',
        'Description',
    ];
    public function myItems()
    {
        return contenue::all();
    }

    public function saveMe($req)
    {
        $this->titre=$req->titre;
        $this->description=$req->description;
        $this->save();
    }
    public function supr($id)
    {
        $contact=contenue::find($id);
        $contact->delete();
    }
    public function mod($req)
    {
        $contact=contenue::find($req->input('id'));
        $contact->titre=$req->input('titre');
        $contact->description=$req->input('description');
        $contact->update();
    }
}
