<?php

namespace App\Http\Requests;

use App\Http\Traits\ApiTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateOverTimeRequest extends FormRequest
{
	use ApiTrait;

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules()
	{
		return [
			'type'       => 'sometimes|required|string',
			'hour_price' => 'sometimes|required|numeric',
		];
	}

	public function failedValidation(Validator $validator)
	{
		throw new HttpResponseException($this->apiResponse(
			'401', 'Validation errors', $validator->errors(), null,));
	}
}
