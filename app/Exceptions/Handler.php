<?php
namespace Lio\Exceptions;

use Bugsnag;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Bugsnag\BugsnagLaravel\BugsnagExceptionHandler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Exception $e
     * @return void
     */
    public function report(Exception $e)
    {
        // If a user is logged in, we'll set him as the target user for which the errors will occur.
        if (auth()->check()) {
            Bugsnag::setUser([
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ]);
        }

        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }

        return parent::render($request, $e);
    }
}
