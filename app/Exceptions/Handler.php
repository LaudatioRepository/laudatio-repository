<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Exceptions\XMLNotWellformedException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
        \ErrorException::class
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if (config('app.debug')) {
            return parent::render($request, $exception);
        }

        return $this->handle($request, $exception);
        //return parent::render($request, $exception);
    }

    /**
     * Convert the Exception into a JSON HTTP Response
     *
     * @param Request $request
     * @param Exception $e
     * @return JSONResponse
     */
    private function handle($request, Exception $e) {
        if ($e instanceOf \ErrorException) {
            $data   = $e->toArray();
            $status = $e->getStatus();
        }

        if ($e instanceOf NotFoundHttpException) {
            $data = array_merge([
                'id'     => 'not_found',
                'status' => '404'
            ], config('errors.not_found'));

            $status = 404;
        }
        else if($e instanceOf XMLNotWellformedException) {
            $data = [
                'errors' => 'Sorry, something went wrong.'
            ];

            // If the app is in debug mode
            if (config('app.debug')) {
                // Add the exception class name, message and stack trace to response
                $data['payload'] = $e->getMessage();
                $data['trace'] = $e->getTrace();
            }

            // Default response of 400
            $status = 400;

            // If this exception is an instance of HttpException
            if ($this->isHttpException($e)) {
                // Grab the HTTP status code from the Exception
                $status = $e->getStatusCode();
            }
        }

        return response()->json($data, $status);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('signin');
    }
}
