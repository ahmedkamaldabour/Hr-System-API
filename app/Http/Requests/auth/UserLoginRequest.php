<?php

namespace App\Http\Requests\auth;

use App\Http\Traits\ApiTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class userLoginRequest extends FormRequest
{
	use ApiTrait;

	// stop the auto redirect to login page

	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize():bool
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
	 */
	public function rules():array
	{
		return [
			'email'    => 'required|email|exists:users,email',
			'password' => 'required|min:6|max:20',
		];
	}

	public function failedValidation(Validator $validator)
	{
		throw new HttpResponseException($this->apiResponse(
			'401', 'Validation errors', $validator->errors(), null));
	}

}
