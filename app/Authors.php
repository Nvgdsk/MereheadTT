<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Authors extends Model
{
    protected $fillable = [
        'firstName', 'lastName'
    ];



    public function books(){
        return $this->hasMany(Books::class,'id');
    }

    public static function add($fields)
    {
        $author = new static;
        $author->fill($fields);
        $author->save();
        return $author;

    }
}
