<?php

namespace App\Repositories;

use Exception;
use App\Models\User;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{
    public function __construct(protected User $model){}

    public function register($request)
    {
        $user = User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'latitude'     => $request->latitude,
            'longitude'    => $request->longitude,
        ]);

        $token = $user->createToken("auth_token")->accessToken;
        $result = [
            "user"  => $user,
            "token" => $token
        ];

        return $result;
    }

    public function login($request)
    {
        try {
            $user = $this->model->where("email", $request->email)->first();

            if (!$user) {
                throw new CustomException("User not found");
            }

            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken("auth_token")->accessToken;

                return $token;
            } else {
                throw new CustomException("User credential dosen't match");
            }
        } catch (Exception $exception) {
            throw $exception;
        }
    }

}
