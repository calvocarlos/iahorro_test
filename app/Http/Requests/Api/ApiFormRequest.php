<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

abstract class ApiFormRequest extends LaravelFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    abstract public function authorize();

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        $error_messages = [];
        foreach ($errors as $error_attribute => $error){
            array_push($error_messages, [
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                "source" => [
                    "pointer" => "/data/attributes/".$error_attribute
                ],
                "title" => "Invalid Attribute",
                "detail" => $error[0]
            ]);
        }

        throw new HttpResponseException(
            response()->json([
                'errors' => $error_messages
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
