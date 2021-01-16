<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterProviderRequest extends FormRequest
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
            'username' => 'required|unique:users',
            'fullname' => 'required',
            'email' => 'nullable|email|unique:users',
            'mobile' => 'required|numeric|unique:users|min:10',
            'password' => 'required|min:6',
            'avatar' => 'nullable|mimes:jpeg,jpg,png,gif',
            'city_id' => 'required|exists:cities,id',
            'nationality_id' => 'required|exists:nationalities,id',
            'store_name' => 'required',
            'opening_time' => 'required',
            'closing_time' => 'required',
            'commercial_register_number' => 'nullable|unique:providers',
            'commercial_register_image' => 'nullable|mimes:jpeg,jpg,png,gif',
            'minimum_charge' => 'nullable|numeric',
            'categories' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'identity_number' => 'required|unique:users',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return mixed
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'false',
            'message' => $validator->messages()->first(),
            'data' => null,
        ], 422)); // 422
    }

    public function getValidatorInstance()
    {
        $data = $this->all();
        if (isset($data['mobile']) && $data['mobile'] != null) {
            $data['mobile'] = filter_mobile_number($data['mobile']);
        }
        $this->getInputSource()->replace($data);
        return parent::getValidatorInstance();
    }
}
