<?php

namespace App\Http\Controllers\api;

use Exception;
use App\Classes\BaseController;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;
use App\Http\Requests\api\LoginRequest;
use Illuminate\Support\Facades\Log;
use App\Repositories\AuthRepository;
use App\Http\Requests\api\RegisterRequest;

class AuthController extends BaseController
{
    public function __construct(protected AuthRepository $repository){}

    /**
     * @OA\Post(
     *     path="/api/register",
     *     tags={"Authentication"},
     *     summary="Register a new user",
     *     description="Create a new user account",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password","password_confirmation"},
     *             @OA\Property(property="name", type="string", example="Albab Hasan"),
     *             @OA\Property(property="email", type="string", format="email", example="albab@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="12345678"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="12345678")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function register(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = $this->repository->register($request);

            DB::commit();

            return $this->sendResponse($user, "User registered successfully", 201);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());

            return $this->sendError('Something went wrong in register');
        }
    }

    /**
     * @OA\Post(
     *     path="/login",
     *     tags={"Authentication"},
     *     summary="User login",
     *     description="Authenticate user and return access token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="superadmin@gmail.com"),
     *             @OA\Property(property="password", type="string", format="password", example="123456")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful, returns token"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials"
     *     )
     * )
     */
    public function login(LoginRequest $request)
    {
        try {
            $token = $this->repository->login($request);

            return $this->sendResponse($token, "Login successful");

        } catch (CustomException $exception) {
            return $this->sendError($exception->getMessage());
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return $this->sendError('Something went wrong');
        }
    }
}
