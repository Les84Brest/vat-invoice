<?php

namespace App\Services\Companies;

use App\Models\Company;
use App\Models\User;

class CompanyService implements CompanyServiceContract
{
    public function store(array $data): Company
    {
        $userIds = $this->getCompanyUserIds($data);
        $data = $this->prepareCompanyData($data);
        $company = Company::create($data);

        if (count($userIds) > 0) {
            foreach ($userIds as $id) {
                $user = User::findOrFail($id);
                $user->company()
                    ->associate($company)
                    ->save();
            }
        }

        return $company;
    }

    public function update(Company $company, array $data): Company
    {
        $this->detachCompanyUsers($company);
        $userIds = $this->getCompanyUserIds($data);
        $data = $this->prepareCompanyData($data);
        $company->update($data);

        if (count($userIds)) {
            foreach ($userIds as $userId) {
                $updatedUser = User::findOrFail($userId);
                $updatedUser->company()
                    ->associate($company)
                    ->save();
            }
        }

        return Company::findOrFail($company->id);
    }

    private function detachCompanyUsers(Company $company): void
    {
        /** @var Illuminate\Support\Collection $users */
        $users = $company->users;

        if ($users->count() > 0) {
            $users->each(function (User $user) {
                $user->company()
                    ->disassociate()
                    ->save();
            });
        }
    }

    private function prepareCompanyData(array $data)
    {
        if (isset($data['users'])) {
            unset($data['users']);
        }

        return $data;
    }

    private function getCompanyUserIds(array $data): array
    {
        $ids = [];

        if (isset($data['users'])) {
            $ids = $data['users'];
        }

        return $ids;
    }
}
