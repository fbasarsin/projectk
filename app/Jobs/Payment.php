<?php

namespace App\Jobs;

use App\Models\Company;
use App\Models\CompanyPackages;
use App\Models\CompanyPayments;
use App\Models\Package;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class Payment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private CompanyPackages $companyPackage;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(CompanyPackages $companyPackage)
    {
        $this->companyPackage = $companyPackage;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $companyPayments = new CompanyPayments();
        $companyPayments->company_id = $this->companyPackage->company_id;
        $companyPayments->package_id = $this->companyPackage->package_id;

        $package = Package::find($this->companyPackage->package_id);

        $companyPayments->price = $package->price;
        $companyPayments->approved = true;
        if(rand(0,100) % 2 == 0){
            $companyPayments->approved = false;
        }

        $companyPayments->save();

        if ($companyPayments::checkPayment(
            $this->companyPackage->end_date,
            $this->companyPackage->company_id,
            $this->companyPackage->package_id
        )) {
            $company = Company::find($this->companyPackage->company_id);
            $company->is_active = false;
            $company->save();
        } else {
            $this->companyPackage->end_date = date('Y-m-d H:i:s', strtotime("+" . $package->month . " months", strtotime($package->end_date)));
            $this->companyPackage->save();
        }
    }
}
