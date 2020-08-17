<?php

namespace App\Http\Controllers;

use App\Authors;
use App\Books;
use Illuminate\Http\Request;

class LiblaryController extends Controller
{
    public function getAuhtors()
    {
        return Authors::all('id','firstName', 'lastName');
    }

    public function getBooks()
    {
        return Books::all();
    }

    public function getBooksAuthor($id)
    {
        $author = Authors::find($id);

        return $author->books;
    }

    public function userBooks()
    {

        return auth()->user()->books;
    }

    public function create(Request $request)
    {
        $this->validate($request,
            [
                'name' => 'required',
                'countPages' => 'required',
                'anotation' => 'required',
                'authorName' => 'required',
                'authorSurname' => 'required|nullable',

            ]);

        //Писали что авторов создавать не нужно, в любой момент можно закоментить
        $authorId = Authors::where([
            ['firstName', '=', $request->get('authorName')],
            ['lastName', '=', $request->get('authorSurname')]])->first()['id'];

        if ($authorId == NULL) {
            $authorId = Authors::add([
                'firstName' => $request->get('authorName'),
                'lastName' => $request->get('authorSurname')])->id;
        }

        $book = Books::add($request->all());
        $book->addUser(auth()->user()->id);
        $book->addAuthor($authorId);
        $book->uploadImage($request->input('image'));

        return "OK";
    }

    public function edit(Request $request)
    {

        $this->validate($request,
            [
                'id' => 'required|integer',
                'name' => 'required',
                'countPages' => 'required',
                'anotation' => 'required',
            ]);
        if (auth()->user()->isMyBook($request->get('id')))
        {
            $book = Books::find($request->get('id'));
            $book->edit($request->all());
            $book->addAuthor($request->get('author_id'));
            $book->uploadImage($request->input('image'));
            return 'Ok';
        }
        return 'access error';
    }

    public function remove($id)
    {

        if (auth()->user()->isMyBook($id)) {
            Books::find($id)->remove();

        }

    }

}
