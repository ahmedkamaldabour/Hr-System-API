<?php

namespace App\Http\Requests;

use App\Http\Traits\ApiTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddAttendRequest extends FormRequest
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
			'employee_id'     => 'required|integer|exists:users,id',
			'attendance_time' => 'required|date_format:H:i:s|before_or_equal:now',
			'attendance_date' => 'required|date_format:Y-m-d|before_or_equal:now',
		];
	}

	public function failedValidation(Validator $validator)
	{
		throw new HttpResponseException($this->apiResponse(
			'401', 'Validation errors', $validator->errors(), null,));
	}

}
