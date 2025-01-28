<?php
namespace App\Core\Post;

class Positions
{
    public const FEATURE = 'FEATURE';
    public const POPULAR = 'POPULAR';

    public static function getAll(): array
    {
        return [
            self::FEATURE => self::FEATURE,
            self::POPULAR => self::POPULAR,
        ];
    }
}