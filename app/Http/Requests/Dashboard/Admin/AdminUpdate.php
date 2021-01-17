<?php

namespace App\Http\Requests\Dashboard\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminUpdate extends FormRequest
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
            'username' => 'required',
            'email' => 'nullable|email|unique:users,email,' . $this->admin,
            'mobile' => 'required|numeric|min:10|unique:users,mobile,' . $this->admin,
            'password' => 'nullable|min:6',
            'avatar' => 'nullable|mimes:jpeg,jpg,png,gif',
            'city_id' => 'required|exists:cities,id',
            'role_id' => 'required|exists:roles,id',
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
