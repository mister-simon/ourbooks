<?php

namespace App\Enums;

enum ReadStatus: string
{
    case YES = 'Y';
    case NO = 'N';
    case PARTIAL = 'P';
    case UNKNOWN = '?';

    public function trans()
    {
        return __(strtolower($this->name));
    }

    public static function select()
    {
        return collect(self::cases())
            ->keyBy('value')
            ->map(fn (ReadStatus $read) => $read->trans());
    }
}
