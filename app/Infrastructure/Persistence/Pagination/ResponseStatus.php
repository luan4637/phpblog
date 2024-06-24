<?php
namespace App\Infrastructure\Persistence\Pagination;

class ResponseStatus {
    const STATUS_FAIL = 'fail';
    const STATUS_SUCCESS = 'success';

    public static function getCode(string $status): int
    {
        $codes = [
            self::STATUS_FAIL => 400,
            self::STATUS_SUCCESS => 200
        ];

        return $codes[$status];
    }
}