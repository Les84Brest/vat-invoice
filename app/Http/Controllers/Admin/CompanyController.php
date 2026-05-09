<?php

namespace App\Http\Controllers\Admin;

use App\Filters\InvoiceFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCompanyRequest;
use App\Http\Requests\Admin\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\User;
use App\Services\Companies\CompanyServiceContract;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
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
    public function store(StoreCompanyRequest $request, CompanyServiceContract $service)
    {
        $data = $request->validated();
        $company = $service->store($data);

        return ['status' => 'success'];
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company): \Illuminate\View\View
    {
        $users = User::where('role', User::ROLE_USER)->get();

        $sentInvoices = Invoice::filter(new InvoiceFilter([
            InvoiceFilter::SENDER_COMPANY_FILTER => [$company->id],
        ]))->with('recipient_company')->get();

        $receivedInvoices = Invoice::filter(new InvoiceFilter([
            InvoiceFilter::RECIPIENT_COMPANY_FILTER => [$company->id],
        ]))->with('sender_company')->get();

        return view('admin.company.show-edit', compact('company', 'users', 'sentInvoices', 'receivedInvoices'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company, CompanyServiceContract $service)
    {
        $data = $request->validated();


        $updatedCompany = $service->update($company, $data);

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
