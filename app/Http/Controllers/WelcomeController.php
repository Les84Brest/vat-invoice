<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function welcome()
    {
        $invoicesCount = Invoice::count();
        $usersCount = User::where('role', User::ROLE_USER)->count();

        return view('welcome', compact('invoicesCount', 'usersCount'));
    }
}
