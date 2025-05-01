<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\AuthUserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterUserController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        $data = $request->validated();


        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'last_name' => $data['last_name'],
            'role' => User::ROLE_USER,
            'password' => Hash::make($data['password']),
        ]);

        return response()->json([
            'message' => 'Пользователь ' . $user->fullName . " успешно зарегистрирован",
            'user' => $user
        ], 201);
    }
}
