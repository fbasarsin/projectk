<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property int $id
 * @property int $company_id
 * @property int $package_id
 * @property float $price
 * @property boolean $approved
 */
class CompanyPayments extends Model
{
    use HasFactory;

    /**
     * @param string $date
     * @param int $company_id
     * @param int $package_id
     * @return bool
     */
    public static function checkPayment(string $date, int $company_id, int $package_id): bool
    {
        return (bool)CompanyPayments::query()
            ->where([
                ['created_at', '>', $date],
                ['company_id', '=', $company_id],
                ['package_id', '=', $package_id],
                ['approved', '=', false]
            ])->count() == 3;
    }

    /**
     * @return array|null
     */
    public static function report(): array|null
    {
        return DB::select('select
                                    DAY(created_at) as day,
                                    SUM(CASE WHEN approved=1 THEN 1 ELSE 0 END) as total_approved,
                                    SUM(CASE WHEN approved=0 THEN 1 ELSE 0 END) as total_declined,
                                    SUM(CASE WHEN approved=1 THEN price ELSE 0 END) as total_approved_price,
                                    SUM(CASE WHEN approved=0 THEN price ELSE 0 END) as total_declined_price
                                from
                                    company_payments
                                    group by DAY(created_at)
                                    ORDER BY DAY(created_at) ASC');
    }
}
