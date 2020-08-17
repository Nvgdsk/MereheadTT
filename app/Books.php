<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Books extends Model
{
    protected $fillable = [
        'name', 'countPages', 'anotation'
    ];

    public static function add($fields)
    {
        $book = new static;
        $book->fill($fields);
        $book->save();
        return $book;

    }


    public function addUser($id)
    {
        $this->user_id = $id;
        $this->save();
    }

    public function addAuthor($id)
    {
        if($id == Null){
            return;
        }
        $this->author_id = $id;
        $this->save();
    }

    public function removeImage()
    {
        if ($this->image != null) {
            Storage::delete('public/' . $this->image);
        }
    }

    public function uploadImage($image)
    {

        $file_name = 'image_' . time() . '.png'; //generating unique file name;

        if ($image != "") {
            $this->removeImage();

            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            Storage::disk('public')->put($file_name, base64_decode($image));
            $this->image = $file_name;
            $this->save();
        }


    }
    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }

    public function remove()
    {
        $this->removeImage();
        $this->delete();
    }

}
