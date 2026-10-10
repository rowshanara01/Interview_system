<?php

namespace App\Http\Controllers\admin;

use Exception;
use App\Classes\BaseController;
use Illuminate\Support\Facades\Log;
use App\Repositories\BookRepository;
use App\Http\Resources\admin\BookResource;

class BookController extends BaseController
{
    public function __construct(protected BookRepository $repository){}

    /**
     * @OA\Get(
     *     path="/admin/books",
     *     tags={"Admin - Books"},
     *     summary="Get all books (Admin only)",
     *     description="Retrieve a complete list of all books shared by users. This endpoint is restricted to admin users only.",
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
     *                     @OA\Property(property="description", type="string", example="A classic American novel about the Jazz Age"),
     *                     @OA\Property(property="user_id", type="integer", example=2),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-15T10:30:00Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-15T10:30:00Z"),
     *                     @OA\Property(
     *                         property="user",
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=2),
     *                         @OA\Property(property="name", type="string", example="Alice Smith"),
     *                         @OA\Property(property="email", type="string", example="alice@example.com")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Invalid or missing token",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden - Admin access required",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Admin access required")
     *         )
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
            $books = $this->repository->getAllBooks();
            $books = BookResource::collection($books);
            return $this->sendResponse($books, 'Books fetched successfully', 200, 'books');
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return $this->sendError(__("common.commonError"));
        }
    }

    /**
     * @OA\Delete(
     *     path="/admin/books/{id}",
     *     tags={"Admin - Books"},
     *     summary="Delete a book (Admin only)",
     *     description="Delete a specific book from the system. This endpoint is restricted to admin users only.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the book to delete",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Book deleted successfully"),
     *             @OA\Property(property="result", type="null", example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Invalid or missing token",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden - Admin access required",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Admin access required")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Book not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $this->repository->destroy($id);
            return $this->sendResponse(null, 'Book deleted successfully', 200);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return $this->sendError(__("common.commonError"));
        }
    }
}
