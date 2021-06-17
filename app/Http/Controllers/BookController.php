<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $books = Book::all();
        return $this->SuccessResponse($books);
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => ['required', 'string',],
            'description' => ['required', 'string',],
            'price' => ['required', 'integer', 'min:20',],
            'author_id' => ['required', 'integer', 'min:1',],
        ];

        //Validar y enviar mensajes de error manualmente si falla | https://medium.com/@rosselli00/validating-in-laravel-7e88bbe1b627
//        $validator = Validator::make($request->all(), $rules);
//
//        if ($validator->fails()) {
//            return response()->json(['data' => ['error' => $validator->errors()]]);
//        }

        //Validar y enviar mensajes de error si falla de forma automatica
        Validator::make($request->all(), $rules)->validate();

        //you actually do not need to check if the validator has failed, Laravel will do that and send back all the necessary messages to the view in the $errors
        //https://laravel.io/forum/12-11-2015-how-to-implement-laravel-request-validation
//        $this->validate($request, $rules);

        $book = Book::create($request->all()); //create funciona con array
//        $book = new Book($request->all());
//        $book->save(); //save funciona con instancias de modelo

        return $this->SuccessResponse($book, Response::HTTP_CREATED);
    }

    public function show(Book $book): \Illuminate\Http\JsonResponse
    {
        return $this->SuccessResponse($book);
    }

    public function update(Book $book, Request $request)
    {
        $rules = [
            'title' => ['string',],
            'description' => ['string',],
            'price' => ['integer', 'min:1',],
            'author_id' => ['integer', 'min:1',],
        ];

        Validator::make($request->all(), $rules)->validate();

        //https://arievisser.com/blog/differences-between-update-and-fill-in-laravel/
        //1er test
        $book->update($request->all()); //actualizar el registro con los datos del request
        //2do test
//        $book->fill($request->all()); //rellenar el registro con los datos del request
        //3er test
//        $book->title = 'modificado posterior'; //fill permite alterar la estructura del objeto antes de almacenarlo en bd
//        $book->save(); //si hemos modificado el objeto, ahora necesitamos guardarlo

        return $this->SuccessResponse($book);
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return $this->SuccessResponse($book);
    }

}
