<?php

namespace App\Helpers;

final class PrepareInput
{
    /**
     * Prepare and process input by passing it through middleware transformations.
     */
    public function prepareInput(array $input): array
    {
        return collect($input)
            ->map(
                fn ($item) => is_array($item)
                    ? $this->prepareInput($item)
                    : $this->prepareItem($item)
            )
            ->all();
    }

    protected function prepareItem($item)
    {
        $item = $this->trimStrings($item);
        $item = $this->nullEmpty($item);

        return $item;
    }

    /** @see \Illuminate\Foundation\Http\Middleware\TrimStrings */
    protected function trimStrings($value)
    {
        if (! is_string($value)) {
            return $value;
        }

        return preg_replace('~^[\s\x{FEFF}\x{200B}]+|[\s\x{FEFF}\x{200B}]+$~u', '', $value) ?? trim($value);
    }

    /** @see \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull */
    protected function nullEmpty($value)
    {
        return $value === '' ? null : $value;
    }

    public static function process(array $input)
    {
        return (new self())
            ->prepareInput($input);
    }
}
