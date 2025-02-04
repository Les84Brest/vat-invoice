<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthUserResource;
use Illuminate\Http\Request;

class AuthDataController extends Controller
{
    public function getAuthUser(Request $request)
    {
        $authUser = request()->user();
        return new AuthUserResource($authUser);
    }
}
