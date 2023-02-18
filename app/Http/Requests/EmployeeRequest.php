<?php

namespace App\Http\Requests;

use App\Http\Traits\ApiTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EmployeeRequest extends FormRequest
{
	use ApiTrait;

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
		switch ($this->method()) {
			case 'POST':
				return [
					'name'          => 'required|string|max:255',
					'email'         => 'required|string|email|max:255|unique:users',
					'password'      => 'required|string|min:8',
					'department_id' => 'nullable|integer|exists:departments,id',
					'branch_id'     => 'nullable|integer|exists:branches,id',
					'role'          => 'required|string|max:255',
					'phone'         => 'required|string|max:255',
					'rate'          => 'required|integer',
					'salary'        => 'required|integer',
				];
			case 'PUT':
				return [
					'name'          => 'required|string|max:255',
					'email'         => 'required|string|email|max:255|unique:users,email,'.$this->id,
					'password'      => 'nullable|string|min:8',
					'branch_id'     => 'nullable|integer|exists:branches,id',
					'department_id' => 'nullable|integer|exists:departments,id',
					'role'          => 'required|string|max:255',
					'phone'         => 'nullable|string|max:255',
					'rate'          => 'required|integer',
					'salary'        => 'nullable|integer',
				];
			default:
				return [];
		}
	}

	public function failedValidation(Validator $validator)
	{
		throw new HttpResponseException($this->apiResponse(
			'401', 'Validation errors', $validator->errors(), null,));
	}

}
