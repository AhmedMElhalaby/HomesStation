<?php

namespace App\Http\Requests\Dashboard\Delegate;

use Illuminate\Foundation\Http\FormRequest;

class DelegateUpdate extends FormRequest
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
            'username' => 'required|unique:users,username,' . $this->delegate,
            'email' => 'nullable|email|unique:users,email,' . $this->delegate,
            'mobile' => 'required|numeric|min:10|unique:users,mobile,' . $this->delegate,
            'password' => 'nullable|min:6',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png,gif',
            'city_id' => 'required|exists:cities,id',
            'nationality_id' => 'nullable|exists:nationalities,id',
            'identity_number' => 'nullable|unique:users,identity_number,' . $this->delegate,
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
