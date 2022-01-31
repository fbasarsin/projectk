<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $company_id
 * @property int $package_id
 * @property string $start_date
 * @property string $end_date
 */
class CompanyPackages extends Model
{
    use HasFactory;

    /**
     * @param int $companyId
     * @return CompanyPackages|null
     */
    public static function getPackageByCompanyId(int $companyId): CompanyPackages|null
    {
        return CompanyPackages::query()
            ->where('company_id', '=', $companyId)
            ->first();
    }

    /**
     * @return Collection|array
     */
    public static function getPackageExpiredCompanies(): Collection|array
    {
        return CompanyPackages::select('company_packages.*')
            ->leftJoin('companies', 'company_packages.company_id', '=', 'companies.id')
            ->where([
                ['company_packages.end_date', '<=', date('Y-m-d H:i:s')],
                ['companies.is_active', '=', true]
            ])
            ->get();
    }
}
