<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyShowResource;
use App\Http\Resources\CompanySuggestResource;
use App\Models\Company;
use Illuminate\Http\Request;

class RecieverCompanyController extends Controller
{
    public function getRecieverIds(Request $request)
    {
        $validatedData = $request->validate([
            'query' => 'required|numeric',
        ]);

        $query = $validatedData['query'];

        $companies = Company::where('tax_id', 'LIKE', "%{$query}%")->get();

        return CompanySuggestResource::collection($companies);
    }

    public function getRecieverCompany(Request $request)
    {
        $validatedData = $request->validate([
            'tax_id' => 'required|numeric',
        ]);

        $taxId = $validatedData['tax_id'];
        $company = Company::where('tax_id', $taxId)->first();

    
        

        return new CompanyShowResource($company);
    }
}
