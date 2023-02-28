<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePeriodRequest extends FormRequest
{
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
			'period_name' => 'required|string',
			'start_time'  => 'required|date_format:H:i|before:end_time',
			'end_time'    => 'required|date_format:H:i|after:start_time',
		];
	}

	public function failedValidation(Validator $validator)
	{
		throw new HttpResponseException($this->apiResponse(
			'401', 'Validation errors', $validator->errors(), null,));
	}
}
