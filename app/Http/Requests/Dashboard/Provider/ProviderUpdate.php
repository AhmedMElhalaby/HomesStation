<?php

namespace App\Http\Requests\Dashboard\Provider;

use Illuminate\Foundation\Http\FormRequest;

class ProviderUpdate extends FormRequest
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
            'username' => 'required|unique:users,username,' . $this->provider,
            'fullname' => 'required',
            'email' => 'nullable|email|unique:users,email,' . $this->provider,
            'mobile' => 'required|numeric|min:10|unique:users,mobile,' . $this->provider,
            'password' => 'nullable|min:6',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png,gif',
            'city_id' => 'required|exists:cities,id',
            'nationality_id' => 'nullable|exists:nationalities,id',
            'is_verified' => 'required',
            'store_name' => 'required',
            'opening_time' => 'required',
            'closing_time' => 'required',
            'commercial_register_number' => 'nullable|unique:providers,commercial_register_number,' . $this->provider . ',user_id',
            'commercial_register_image' => 'nullable|image|mimes:jpeg,jpg,png,gif',
            'minimum_charge' => 'nullable|numeric',
            'categories' => 'required',
        ];
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
