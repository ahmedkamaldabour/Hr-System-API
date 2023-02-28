<?php

namespace App\Http\Requests;

use App\Http\Traits\ApiTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class VacationRequest extends FormRequest
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
            "employee_id" => "required|exists:users,id",
            "start_date" => "required|date",
            "end_date" => "required|date",
            "vacation_type" => "required"
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
