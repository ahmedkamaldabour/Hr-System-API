<?php

namespace App\Http\Middleware;

use App\Http\Traits\ApiTrait;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
	use ApiTrait;

	/**
	 * Get the path the user should be redirected to when they are not authenticated.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return string|null
	 */
	protected function redirectTo($request)
	{
		return $this->apiResponse(412, 'Unauthenticated', 401, null);

		//		dd($request->expectsJson());
		if (!$request->expectsJson()) {
			return route('login');
			//			return $this->apiResponse(401, 'Unauthenticated', 401, null);
		}

	}
}
