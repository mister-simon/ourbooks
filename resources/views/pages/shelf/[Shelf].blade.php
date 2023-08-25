<?php

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RequireUserName;
use function Laravel\Folio\{middleware, name};
use Illuminate\Auth\Middleware\Authorize;

name('shelf');
middleware([Authenticate::class, RequireUserName::class]);
middleware([Authorize::using('view', 'shelf')]);

?>
<x-layouts.app :title="$shelf->title">
    <livewire:shelf-show :shelf="$shelf" />
</x-layouts.app>
