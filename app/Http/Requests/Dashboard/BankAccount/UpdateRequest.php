<?php

namespace App\Http\Requests\Dashboard\BankAccount;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'bank_name' => 'required',
            'owner_account' => 'required',
            'account_number' => 'required',
            'logo_bank' => 'nullable|mimes:jpeg,jpg,png,gif',
        ];
    }
}
