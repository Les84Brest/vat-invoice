<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class PasswordConfirmController extends Controller
{
    public function confirm(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Пользователь не авторизован', 403]);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Неправильный пароль',
                'errors'  => [
                    'password' => 'Неправильный пароль',
                ],
            ], 422);
        }

        // Store a confirmation timestamp (e.g., for 2 minutes)
        Cache::put('password_confirmed_' . $user->id, now()->timestamp, now()->addMinutes(2));

        return response()->json([
            'success' => true,
        ]);
    }
}
