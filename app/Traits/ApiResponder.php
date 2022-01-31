<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponder
{
    /**
     * @param array $data
     * @param int $code
     * @param string $msg
     * @return JsonResponse
     */
    protected function success(array $data = [], int $code = 200, string $msg = 'OK'): JsonResponse
    {
        return response()->json([
            array_merge($data, ['status' => [
                'code' => $code,
                'success' => true,
                'msg' => $msg
            ]])
        ]);
    }

    /**
     * @param array $data
     * @param int $code
     * @param string $msg
     * @return JsonResponse
     */
    protected function error(array $data = [], int $code = 422, string $msg = ''): JsonResponse
    {
        return response()->json([
            array_merge($data, ['status' => [
                'code' => $code,
                'success' => false,
                'msg' => $msg
            ]])
        ]);
    }
}
