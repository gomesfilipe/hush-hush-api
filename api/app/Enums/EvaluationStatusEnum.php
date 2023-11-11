<?php

namespace App\Enums;

enum EvaluationStatusEnum: string
{
    case LIKE = 'Like';
    case DISLIKE = 'Dislike';
    case NONE = 'None';

    public static function keys(): array
    {
        return array_keys(self::cases());
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
