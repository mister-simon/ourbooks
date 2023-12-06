<?php

namespace App\Enums;

enum ReadStatus: string
{
    case YES = 'Y';
    case NO = 'N';
    case PARTIAL = 'P';
    case UNKNOWN = '?';

    public function rank()
    {
        return match ($this) {
            self::YES => 3,
            self::PARTIAL => 2,
            self::NO => 1,
            self::UNKNOWN => 0,
        };
    }

    public function transShort()
    {
        return __('readstatus.'.strtolower($this->name).'-short');
    }

    public function trans()
    {
        return __('readstatus.'.strtolower($this->name));
    }

    public static function select()
    {
        return collect(self::cases())
            ->keyBy('value')
            ->map(fn (ReadStatus $read) => $read->trans());
    }
}
