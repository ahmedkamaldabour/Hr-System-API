<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\UserLoginRequest;
use App\Http\Traits\ApiTrait;
use Illuminate\Support\Facades\Auth;
use function auth;


class AuthController extends Controller
{
	use ApiTrait;

	public function login(UserLoginRequest $request)
	{
		$credentials = $request->only('email', 'password');
		if (auth()->attempt($credentials)) {
			$token = auth()->user()->createToken('auth_token')->plainTextToken;
			$data = [
				'user'  => auth()->user(),
				'token' => $token,
			];
			return $this->apiResponse('200', 'Logged in successfully', null, $data);
		}
		return $this->apiResponse('401', 'Invalid Credentials', null, null);
	}

	public function user()
	{
		$user = Auth::guard('sanctum')->user();
		//		$user = auth()->user();
		if (!$user) {
			return $this->apiResponse('401', 'Invalid Credentials', null, null);
		}
		// get his department and branch
		$user = $user->load('department', 'branch');
		return $this->apiResponse('200', 'User data', 'null', $user);
	}

	public function logout()
	{
		Auth::guard('sanctum')->user()->currentAccessToken()->delete();
		return $this->apiResponse('200', 'Logged out successfully', null, null);
	}

}