<?php

namespace App\Exceptions;

use Exception;
/*use Illuminate\Validation\ValidationException;*/
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler {

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     * 
     * Modified for API
     * 
     * Make sure all your API requests specify:
     *      Accept: application/json
     * in header
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $statusCode = 500;

            // you can use custom Exceptions
            if (method_exists($e, 'getStatusCode')) {
                $statusCode = $e->getStatusCode();
            }
            
            $classNameParts = explode('\\', get_class($e));
            
            return response()->json(
                            [
                        'message' => $e->getMessage(),
                        'code' => $statusCode,
                        'type' => array_pop($classNameParts), // extract only class name without namespace
                        'data' => (method_exists($e, 'getErrorData')) ? $e->getErrorData() : NULL
                            ], $statusCode
            );
        }
        return parent::render($request, $e);
    }

}
