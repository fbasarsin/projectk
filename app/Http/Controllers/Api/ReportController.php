<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CompanyPayments;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;

class ReportController extends Controller
{
    use ApiResponder;

    /**
     * @return JsonResponse
     */
    public function paymentReport(): JsonResponse
    {
        #todo add auth control

        $list = CompanyPayments::report();

        return $this->success(['data' => $list]);
    }
}
