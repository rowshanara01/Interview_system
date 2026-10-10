<?php

namespace App\Http\Controllers\admin;

use Exception;
use App\Classes\BaseController;
use Illuminate\Support\Facades\Log;
use App\Repositories\UserRepository;
use App\Http\Resources\admin\UserResource;

class UserController extends BaseController
{
    public function __construct(protected UserRepository $repository){}

    /**
     * @OA\Get(
     *     path="/admin/users",
     *     tags={"Admin - Users"},
     *     summary="Get all users (Admin only)",
     *     description="Retrieve a list of all registered users. This endpoint is restricted to admin users only.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Users fetched successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Users fetched successfully"),
     *             @OA\Property(
     *                 property="result",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="John Doe"),
     *                     @OA\Property(property="email", type="string", example="john@example.com"),
     *                     @OA\Property(property="latitude", type="number", format="float", example=40.7128),
     *                     @OA\Property(property="longitude", type="number", format="float", example=-74.0060),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-15T10:30:00Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-15T10:30:00Z")
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
            $users = $this->repository->index();
            $users = UserResource::collection($users);
            return $this->sendResponse($users, "Users fetched successfully");
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return $this->sendError('Something went wrong in index');
        }
    }
}
