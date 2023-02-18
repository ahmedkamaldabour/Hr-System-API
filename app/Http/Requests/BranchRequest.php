<?php

namespace App\Http\Requests;

use App\Http\Traits\ApiTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use function Symfony\Component\Translation\t;

class BranchRequest extends FormRequest
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
					'name' => 'required|string|max:255|unique:branches,name',
				];
			case 'PUT':
				return [
					'name' => 'required|string|max:255|unique:branches,name,'.$this->id,
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
