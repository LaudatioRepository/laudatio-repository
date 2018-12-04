<?php
/**
 * Created by PhpStorm.
 * User: rolfguescini
 * Date: 12.10.18
 * Time: 08:21
 */

namespace App\Exceptions;


use App\Custom\LaudatioExceptionInterface;

class XMLNotWellformedException extends \RuntimeException implements LaudatioExceptionInterface
{

    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {

        parent::__construct($message, $code, $previous);
    }
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
    }
    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        // If the request wants JSON (AJAX doesn't always want JSON)
        //if ($request->wantsJson()) {
            // Define the response
            $response = [
                'errors' => 'Sorry, something went wrong.'
            ];

            // If the app is in debug mode
            if (config('app.debug')) {
                // Add the exception class name, message and stack trace to response
                $response['exception'] = get_class($e); // Reflection might be better here
                $response['message'] = $e->getMessage();
                $response['trace'] = $e->getTrace();
            }

            // Default response of 400
            $status = 400;

            // If this exception is an instance of HttpException
            if ($this->isHttpException($e)) {
                // Grab the HTTP status code from the Exception
                $status = $e->getStatusCode();
            }

            // Return a JSON response with the response array and status code
            return response()->json($response, $status);
        //}

        // Default to the parent class' implementation of handler
        return parent::render($request, $e);
    }


}