<?php

namespace App\Http\Requests;

use App\Http\Traits\ApiTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePositionRequest extends FormRequest
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
			'name'        => 'required|string|max:255',
			'description' => 'nullable|string|max:255',
		];
	}

	public function failedValidation(Validator $validator)
	{
		throw new HttpResponseException($this->apiResponse(
			'401', 'Validation errors', $validator->errors(), null,));
	}
}
