<?php

namespace App\Helpers;

use App\Http\Middleware\TrimStrings;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Http\Request;

final class PrepareInput
{
    /**
     * Prepare and process input by passing it through middleware transformations.
     */
    public function prepareInput(array $input): array
    {
        $request = new Request;
        $request->merge($input);

        $output = $this->trimStrings($request);

        dd($output);
    }

    protected function trimStrings(Request $request)
    {
        return tap(
            new TrimStrings,
            fn (TrimStrings $trim) => $trim->flushState()
        )->handle(
            $request,
            fn (Request $request) => $this->convertEmptyStringsToNull($request)
        );
    }

    protected function convertEmptyStringsToNull(Request $request)
    {
        return tap(
            new ConvertEmptyStringsToNull,
            fn (ConvertEmptyStringsToNull $nullify) => $nullify->flushState()
        )->handle(
            $request,
            fn (Request $request) => $this->preparedInput($request)
        );
    }

    protected function preparedInput(Request $request)
    {
        return $request->all();
    }

    public static function make()
    {
        return new self();
    }
}
