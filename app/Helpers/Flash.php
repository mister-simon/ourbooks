<?php

namespace App\Helpers;

use Illuminate\Support\Traits\ForwardsCalls;

/**
 * @method \App\Helpers\Flash danger()
 * @method \App\Helpers\Flash success()
 * @method \App\Helpers\Flash info()
 * @method static \App\Helpers\Flash danger()
 * @method static \App\Helpers\Flash success()
 * @method static \App\Helpers\Flash info()
 */
final class Flash
{
    use ForwardsCalls;

    public function flash($style, string $message)
    {
        session()->flash('flash', [
            'bannerStyle' => $style,
            'banner' => $message,
        ]);

        return $this;
    }

    public static function __callStatic($method, $parameters)
    {
        return (new self)->flash($method, ...$parameters);
    }

    public function __call($method, $parameters)
    {
        return $this->flash($method, ...$parameters);
    }
}
