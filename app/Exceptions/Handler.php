<?php

namespace App\Exceptions;

use App\Http\Traits\ApiTrait;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use function dd;
use function redirect;
use function request;

class Handler extends ExceptionHandler
{
	use ApiTrait;

	/**
	 * A list of the exception types that are not reported.
	 *
	 * @var array<int, class-string<Throwable>>
	 */
	protected $dontReport
		= [
			//
		];

	/**
	 * A list of the inputs that are never flashed for validation exceptions.
	 *
	 * @var array<int, string>
	 */
	protected $dontFlash
		= [
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
		$this->reportable(function (Throwable $e) {});
	}

	public function render($request, Throwable $e)
	{
		if ($e instanceof NotFoundHttpException) {
			return $this->apiResponse(404, 'Page Not Found', $request->url().' Not Found, try with correct url', "null");
		}
		if ($e instanceof MethodNotAllowedHttpException) {
			return $this->apiResponse(405, 'Method Not Allowed', $request->method().' Method Not Allowed, try with correct method', 'null');
		}
		if ($e instanceof AuthenticationException) {
			return $this->unauthenticated($request, $e);
		}
	}

	protected function unauthenticated($request, AuthenticationException $exception)
	{
		if ($request->expectsJson()) {
			return $this->apiResponse(401, 'Unauthenticated', null, null);
		}
		return redirect()->guest('login');
	}

}
