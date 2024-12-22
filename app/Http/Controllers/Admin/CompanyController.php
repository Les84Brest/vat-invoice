<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::all()->sortBy('short_title');

        return view('admin.company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', User::ROLE_USER)->get();

        return view('admin.company.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpdateCompanyRequest $request)
    {
        $data = $request->validated();

        if (isset($data['users'])) {
            $userIds = $data['users'];
            unset($data['users']);
        }

        $company = Company::create($data);

        if(isset($userIds)){
            foreach ($userIds as $id) {
                $user = User::findOrFail($id);
                $user->company_id = $company->id;
                $user->save();
            }
        }

        return ['status'=> 'success'];
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        $users = User::where('role', User::ROLE_USER)->get();

        return view('admin.company.show-edit', compact('company', 'users'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $data = $request->validated();


        if (isset($data['users'])) {
            $userIds = $data['users'];
            unset($data['users']);
        }

        $company->update($data);

        $companyUsers = $company->users;
        foreach ($companyUsers as $companyUser) {
            $companyUser->company_id = null;
            $companyUser->save();
        }

        if (isset($userIds)) {
            foreach ($userIds as $id) {
                $user = User::findOrFail($id);
                $user->company_id = $company->id;
                $user->save();
            }
        }

        return ['status' => 'success'];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = Company::findOrFail($id);

        $company->delete();

        return ['status' => 'success'];
    }
}
