<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function generatePassword($password)
    {
        if ($password != null) {
            $this->password = bcrypt($password);

        }
    }

    public function books()
    {
        return $this->hasMany(Books::class);
    }

    public static function add($fields)
    {
        $user = new static;
        $user->fill($fields);
        $user->generatePassword($fields['password']);
        $user->save();
        return $user;
    }

    public function isMyBook($id)
    {

        if ($this->books()->find($id) != NULL){
            return true;
        }
        return false;

    }
}
