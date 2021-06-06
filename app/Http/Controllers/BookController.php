<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{

    use ApiResponser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }



    /**
     * Return the list of books
     * @return illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::orderBy('id', 'DESC')->get();
        return $this->successResponse($books, Response::HTTP_OK);
    }

    /**
     * Create one new book
     * @return illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = [
            'title' => 'required|max:100',
            'description' => 'required',
            'author_id' => 'required',
            'price' => 'required'
        ];
        $messages = [
            'title.required' => 'Campo title é obrigatório!',
            'title.max' => 'Campo title deve possuir no máximo 100 caracteres!',
            'description.required' => 'Campo description é obrigatório!',
            'author_id.required' => 'Campo author_id é obrigatório!',
            'price.required' => 'Campo price é obrigatório!',
        ];


        $this->validate($request, $validate, $messages);

        $book = Book::create($request->all());

        return $this->successResponse($book, Response::HTTP_CREATED);
    }

    /**
     * Get an instance of book
     * @return illuminate\Http\Response
     */
    public function show($book)
    {
        $book = Book::findOrFail($book);
        return $this->successResponse($book);
    }

    /**
     * Update an instance of book
     * @return illuminate\Http\Response
     */
    public function update($book, Request $request)
    {

        $validate = [
            'title' => 'max:100',
        ];
        $messages = [
            'title.max' => 'Campo title deve possuir no máximo 100 caracteres!',
        ];

        $this->validate($request, $validate, $messages);

        $book = Book::findOrFail($book);

        $book->fill($request->all());

        if ($book->isClean()) {
            return $this->errorResponse('Não foi possível alterar nenhum valor com as informações informadas.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $book->save();

        return $this->successResponse($book);
    }

    /**
     * Delete an instance of book
     * @return illuminate\Http\Response
     */
    public function destroy($book)
    {

        $book = Book::findOrFail($book);
        if (!$book) {
            return $this->errorResponse('Não foi possível encontrar nenhum book com esse ID', Response::HTTP_UNPROCESSABLE_ENTITY);
        }


        $book->delete();

        return $this->successResponse($book);
    }
}
