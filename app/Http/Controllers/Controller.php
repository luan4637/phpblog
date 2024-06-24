<?php

namespace App\Http\Controllers;

use App\Infrastructure\Persistence\Pagination\PaginationResultInterface;
use App\Infrastructure\Persistence\Pagination\ResponseStatus;

abstract class Controller
{
    /**
     * @param mixed $results
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseSuccess($results)
    {
        if ($results instanceof PaginationResultInterface) {
            return response()->json(
                $results,
                ResponseStatus::getCode(ResponseStatus::STATUS_SUCCESS)
            );
        }

        return response()->json([
            'status' => ResponseStatus::STATUS_SUCCESS,
            'data' => $results
        ], ResponseStatus::getCode(ResponseStatus::STATUS_SUCCESS));
    }

    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseFail($message)
    {
        return response()->json([
            'status' => ResponseStatus::STATUS_FAIL,
            'message' => $message
        ], ResponseStatus::getCode(ResponseStatus::STATUS_FAIL));
    }
}
