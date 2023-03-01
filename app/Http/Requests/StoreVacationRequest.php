<?php

namespace App\Http\Requests;

use App\Http\Traits\ApiTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreVacationRequest extends FormRequest
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
			// validation on all requests
			"employee_id"   => "required|exists:users,id",
			// the start date must be before the end date and can be in the past
			"start_date"    => "required|date|before_or_equal:end_date",
			"end_date"      => "required|date|after_or_equal:start_date",
			// start data and end date must be unique for each employee
			"start_date"    => "unique:vacations,start_date,NULL,id,employee_id,".$this->employee_id,
			"end_date"      => "unique:vacations,end_date,NULL,id,employee_id,".$this->employee_id,
			"vacation_type" => "sometimes|required|in:approved,pending,rejected",
		];
	}

	public function failedValidation(Validator $validator)
	{
		throw new HttpResponseException($this->apiResponse(
			'401',
			'Validation errors',
			$validator->errors(),
			null,
		));
	}
}
