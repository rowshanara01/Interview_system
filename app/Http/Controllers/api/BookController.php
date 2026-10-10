<?php

namespace App\Http\Controllers\api;

use Exception;
use App\Classes\BaseController;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\api\BookRequest;
use App\Repositories\BookRepository;
use App\Http\Resources\api\BookResource;

class BookController extends BaseController
{
    public function __construct(protected BookRepository $repository){}

    /**
     * @OA\Get(
     *     path="/books/nearby",
     *     tags={"Books"},
     *     summary="Get nearby books",
     *     description="Get list of books shared by users within 10km radius of current user location",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Books fetched successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Books fetched successfully"),
     *             @OA\Property(
     *                 property="books",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="title", type="string", example="The Great Gatsby"),
     *                     @OA\Property(property="author", type="string", example="F. Scott Fitzgerald"),
     *                     @OA\Property(property="description", type="string", example="A classic American novel"),
     *                     @OA\Property(property="user_id", type="integer", example=2),
     *                     @OA\Property(property="distance", type="string", example="3.18 km"),
     *                     @OA\Property(
     *                         property="user",
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=2),
     *                         @OA\Property(property="name", type="string", example="Alice Smith")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function index()
    {
        try {
            $books = $this->repository->index();
            $books = BookResource::collection($books);
            return $this->sendResponse($books, 'Books fetched successfully', 200, 'books');
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return $this->sendError(__("common.commonError"));
        }
    }

    /**
     * @OA\Post(
     *     path="/books",
     *     tags={"Books"},
     *     summary="Share a new book",
     *     description="Share a new book with other users in the community",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","author","description"},
     *             @OA\Property(property="title", type="string", maxLength=255, example="The Great Gatsby"),
     *             @OA\Property(property="author", type="string", maxLength=255, example="F. Scott Fitzgerald"),
     *             @OA\Property(property="description", type="string", example="A classic American novel about the Jazz Age")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Book shared successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Book shared successfully"),
     *             @OA\Property(
     *                 property="book",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="The Great Gatsby"),
     *                 @OA\Property(property="author", type="string", example="F. Scott Fitzgerald"),
     *                 @OA\Property(property="description", type="string", example="A classic American novel"),
     *                 @OA\Property(property="user_id", type="integer", example=1)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function store(BookRequest $request)
    {
        try {
            $book = $this->repository->store($request);
            $book = new BookResource($book);
            return $this->sendResponse($book, 'Book shared successfully', 201, 'book');
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->sendError(__("common.commonError"));
        }
    }
}
