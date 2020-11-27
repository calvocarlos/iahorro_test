<?php

namespace App\Http\Requests\Api;

use App\Models\MortgageApplication;

/**
 * Class CreateMortgageApplicationRequest
 *
 * @package App\Http\Requests
 */
class CreateMortgageApplicationRequest extends ApiFormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|min:3|max:32',
            'last_name' => 'required|min:3|max:64',
            'email' => 'required|email|unique:'.(new MortgageApplication())->getTable().',email',
            'phone_number' => 'required|min:12|max:32|regex:/^\+\d{1,3}[0-9]{9}$/',
            'net_income' => 'required|numeric|max:9999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'requested_amount' => 'required|numeric|max:9999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'start_time_slot' => 'required|numeric|between:0,23',
            'end_time_slot' => 'required|numeric|between:0,23',
        ];
    }

    /**
     * Messages
     *
     * @return array
     */
    public function messages()
    {
        return [

        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'first_name' => 'first name',
            'last_name' => 'last name',
            'phone_number' => 'phone number',
            'net_income' => 'net income',
            'requested_amount' => 'requested amount',
        ];
    }
}
