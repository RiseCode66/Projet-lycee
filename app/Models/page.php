<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;
use Illuminate\Support\Facades\DB;

class page extends Model
{
    protected $table='page';
    use HasTrixRichText;
    protected $guarded = [];
    public function getPage($titre)
    {
        $page=DB::table('page')->where('slug','=',$titre)->get();
        return $page;
    }
}
