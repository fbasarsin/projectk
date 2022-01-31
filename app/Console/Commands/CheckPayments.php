<?php

namespace App\Console\Commands;

use App\Jobs\Payment;
use App\Models\CompanyPackages;
use Illuminate\Console\Command;

class CheckPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $companyPackage = new CompanyPackages();
        $rows = $companyPackage->getPackageExpiredCompanies();

        foreach ($rows as $row){
            Payment::dispatch($row);
        }
    }
}
