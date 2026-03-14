<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    //use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
    public function getAll()
    {
        $user=user::all();
        return user::all();
    }
    public function supr($id)
    {
        $user=User::find($id);
        $user->delete();
    }
    public function mod($req)
    {
        $user=User::find($req->input('id'));
        $user->name=$req->input('name');
        $user->email=$req->input('email');
        $user->password=$req->input('password');
        $user->type=$req->input('type_user');
        $user->update();
    }
    public function myMod($req)
    {
        $user=User::find($req->input('id'));
        $user->name=$req->input('name');
        $user->email=$req->input('email');
        $user->password=$req->input('password');
        $user->update();
    }


}
