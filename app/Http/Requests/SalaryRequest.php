<?php

namespace App\Http\Requests;

use App\Http\Traits\ApiTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class SalaryRequest extends FormRequest
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
            // validate on all requests
            "employee_id" => "required|exists:users,id",
            "amount" => "required|integer",
            "bonus" => "sometimes|integer",
            "deduction" => "sometimes|integer",
            "net_salary" => "sometimes|integer",
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
