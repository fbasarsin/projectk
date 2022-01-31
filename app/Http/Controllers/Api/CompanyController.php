<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyPackage;
use App\Http\Requests\CompanyRegisterRequest;
use App\Models\Company;
use App\Models\CompanyPackages;
use App\Models\Package;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    use ApiResponder;

    public function register(CompanyRegisterRequest $request): JsonResponse
    {
        $request->validated();

        // add company
        $company = new Company();
        $company->site_url = $request->site_url;
        $company->name = $request->name;
        $company->last_name = $request->last_name;
        $company->company_name = $request->company_name;
        $company->email = $request->email;
        $company->password = Hash::make($request->password);
        $company->save();

        // create token for company
        $token = $company->createToken('company-token')->plainTextToken;

        return $this->success([
            'company_id' => $company->id,
            'token' => $token
        ]);
    }

    public function assignPackage(CompanyPackage $request): JsonResponse
    {
        $request->validated();

        // check company owner
        if (Auth::id() != $request->company_id) {
            return $this->error([
                'company_id' => $request->company_id,
            ], msg: 'You dont have access for this company!');
        }

        // check package is defined
        if (!$package = Package::find($request->package_id)) {
            return $this->error([
                'package_id' => $request->package_id,
            ], msg: 'Package undefined');
        }

        // check package is already assigned
        if (CompanyPackages::getPackageByCompanyId($request->company_id)) {
            return $this->error([
                'package_id' => $request->package_id,
                'company_id' => $request->company_id
            ], msg: 'This package has already assigned!');
        }

        $companyPackages = new CompanyPackages();
        $companyPackages->company_id = $request->company_id;
        $companyPackages->package_id = $request->package_id;
        $companyPackages->start_date = date('Y-m-d H:i:s');
        $companyPackages->end_date = date('Y-m-d H:i:s', strtotime("+" . $package->month . " months"));
        $companyPackages->save();

        return $this->success([
            'start_date' => $companyPackages->start_date,
            'end_date' => $companyPackages->end_date,
            "package" => $package->name
        ]);
    }

    public function checkPackage(): JsonResponse
    {
        $companyId = Auth::id();
        $company = Company::find($companyId);

        $data = [
            'company_id' => $company->id,
            'company_name' => $company->name,
            'package_id' => null,
            'package_name' => null
        ];

        if($companyPackage = CompanyPackages::getPackageByCompanyId($companyId)){
            $package = Package::find($companyPackage->package_id);
            $data['package_id'] = $package->id;
            $data['package_name'] = $package->name;
        }

        return $this->success($data);
    }
}
