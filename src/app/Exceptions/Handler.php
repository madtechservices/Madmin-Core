<?php

namespace Madtechservices\MadminCore\app\Exceptions;

use Illuminate\Support\Facades\Log;
use Symfony\Component\Mailer\Exception\TransportException;
use Throwable;


class Handler extends \Illuminate\Foundation\Exceptions\Handler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            if ($this->shouldReport($e)) {
                store_system_logs($e);
            }
        });
    }

    public function report(Throwable $exception)
    {
        if ($exception instanceof TransportException) {
            Log::error($exception->getMessage());
            abort(500, __('An error occured while sending the email.'));
        }
        parent::report($exception);
    }
}
