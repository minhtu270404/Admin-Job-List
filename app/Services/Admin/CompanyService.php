<?php

namespace App\Services\Admin;

use App\Models\Company;
use Illuminate\Support\Facades\Storage;

class CompanyService
{
    public function getAll($search = null)
    {
        $query = Company::query();

        if ($search) {
            $query->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%");
        }

        return $query->latest()->paginate(10);
    }

    public function create(array $data): Company
    {
        $data = $this->handleFiles($data);

        return Company::create($data);
    }

    public function update(Company $company, array $data): Company
    {
        $data = $this->handleFiles($data, $company);

        $company->update($data);

        return $company;
    }

    public function delete(Company $company): void
    {
        // Xóa file logo & banner nếu có
        if ($company->logo) {
            Storage::delete($company->logo);
        }
        if ($company->banner) {
            Storage::delete($company->banner);
        }

        $company->delete();
    }

    /**
     * Xử lý upload file logo và banner
     */
    protected function handleFiles(array $data, ?Company $company = null): array
    {
        // Logo
        if (isset($data['logo']) && $data['logo']) {
            if ($company?->logo) {
                Storage::delete($company->logo);
            }
            $data['logo'] = $data['logo']->store('companies/logo', 'public');
        }

        // Banner
        if (isset($data['banner']) && $data['banner']) {
            if ($company?->banner) {
                Storage::delete($company->banner);
            }
            $data['banner'] = $data['banner']->store('companies/banner', 'public');
        }

        return $data;
    }
}
