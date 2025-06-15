<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\password;

class AuthController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }



    public function loginUser(Request $request)
    {
        $authCredentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!isset($user)) {
            return response()->json([
                "error" => "Неправильные реквизиты",
            ], 401);
        }

        if ($user->role != User::ROLE_ADMIN) {
            return response()->json([
                "error" => "Только администратор имеет право пользоваться админ панелью",
            ], 401);
        }

        if (Auth::attempt($authCredentials)) {
            $request->session()->regenerate();
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                "sussess" => true,
                'user' => $user,
                'token' => $token
            ], 200);
        }

        return response()->json([
            "error" => "Неправильные реквизиты",
        ], 401);
    }

    public function register()
    {
        return view('admin.register');
    }

    public function adminLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
