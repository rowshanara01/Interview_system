<?php

namespace App\Repositories;

use Exception;
use App\Models\Book;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;

class BookRepository
{
    public function __construct(protected Book $model){}

    public function index()
    {
        $user = auth()->user();
        $latitude = $user->latitude;
        $longitude = $user->longitude;

        $radius = config('app.nearby_books_radius', 10);

        $books = $this->model
            ->with('user')
            ->selectRaw(
                "books.*,
                (6371 * acos(cos(radians(?))
                * cos(radians(users.latitude))
                * cos(radians(users.longitude) - radians(?))
                + sin(radians(?))
                * sin(radians(users.latitude)))) AS distance",
                [$latitude, $longitude, $latitude]
            )
            ->join('users', 'users.id', '=', 'books.user_id')
            ->where('books.user_id', '!=', $user->id)
            ->having('distance', '<', $radius)
            ->orderBy('distance')
            ->get();

        return $books;
    }
    public function store($request)
    {
        try {
            DB::beginTransaction();

            $book = new $this->model();

            $book->title       = $request->title;
            $book->author      = $request->author;
            $book->description = $request->description;
            $book->user_id     = auth()->id();
            $book->save();

            DB::commit();

            return $book;
        } catch (Exception $exception) {
            DB::rollback();

            throw $exception;
        }
    }

    public function getAllBooks()
    {
        $books = $this->model->with("user:id,name")
                              ->select("id", "title", "author", "user_id")
                              ->orderBy("title", "ASC")
                              ->get();
        return $books;
    }

    public function destroy($id)
    {
        $book = $this->model->find($id);
        $book->delete();
    }

}
