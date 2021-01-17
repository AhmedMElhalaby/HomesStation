<?php

namespace App\Http\Requests\Dashboard\Delegate;

use Illuminate\Foundation\Http\FormRequest;

class DelegateStore extends FormRequest
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
            'email' => 'nullable|email|unique:users',
            'mobile' => 'required|numeric|unique:users|min:10',
            'password' => 'required|min:6',
            'avatar' => 'nullable|mimes:jpeg,jpg,png,gif',
            'city_id' => 'required|exists:cities,id',
            'nationality_id' => 'nullable|exists:nationalities,id',
            'identity_number' => 'nullable|unique:users',
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
