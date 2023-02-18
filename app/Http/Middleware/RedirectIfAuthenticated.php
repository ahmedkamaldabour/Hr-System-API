<?php

namespace App\Http\Middleware;

use App\Http\Traits\ApiTrait;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
	use ApiTrait;

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request                                                                           $request
	 * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
	 * @param  string|null                                                                                        ...$guards
	 * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
	 */
	public function handle(Request $request, Closure $next, ...$guards)
	{
		$guards = empty($guards) ? [null] : $guards;

		foreach ($guards as $guard) {
			if (Auth::guard($guard)->check()) {
				//				return redirect(RouteServiceProvider::HOME);
				return $this->apiResponse(401, 'You are already logged in', 'null', 'null');

			}
		}

		return $next($request);
	}
}
