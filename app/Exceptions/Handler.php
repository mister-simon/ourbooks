<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Spatie\Honeypot\Events\SpamDetectedEvent;
use Spatie\Honeypot\Exceptions\SpamException;
use Spatie\Honeypot\SpamResponder\SpamResponder;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (SpamException $e, Request $request) {
            event(new SpamDetectedEvent($request));

            return app(SpamResponder::class)
                ->respond($request, fn () => null);
        });
    }
}
