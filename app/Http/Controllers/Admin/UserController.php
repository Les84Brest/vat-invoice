<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\Company;
use App\Models\User;
use App\Services\Users\UserServiceContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('company')
            ->where('role', User::ROLE_USER)
            ->get();

        $companies = Company::all();

        return view('admin.user.index', compact('users', 'companies'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $companies = Company::all();

        return view('admin.user.show-edit', compact('companies', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user, UserServiceContract $service)
    {
        $data = $request->validated();
        $user = $service->update($user, $data);

        return [
            'status' => 'success',
            'data' => ["companyName" => $user->company->title]
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return (
            [
                "status" => 'success',
            ]
        );
    }
}
