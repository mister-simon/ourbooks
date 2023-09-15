<?php

return [
    'list' => collect(
        explode(',', env('WHITELIST_IPS', ''))
    )
        ->map(fn ($ip) => trim($ip))
        ->filter(fn ($ip) => $ip !== '')
        ->all(),
];
