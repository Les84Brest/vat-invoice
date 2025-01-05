<?php

namespace App\Services\Companies;

use App\Models\Company;

interface CompanyServiceContract
{
    public function store(array $data): Company;
    public function update(Company $company, array $data): Company;
}
