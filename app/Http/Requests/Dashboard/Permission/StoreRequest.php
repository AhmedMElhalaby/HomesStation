<?php

namespace App\Http\Requests\Dashboard\Permission;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'role_ar' => 'required',
            'role_en' => 'required',
            'plan' => 'required|array|min:1',
        ];
    }

    public function getValidatorInstance()
    {
        $data = $this->all();
        if (isset($data['perms']) && $data['perms'] != null) {
            $data['plan'] = $data['perms'];
        }
        unset($data['perms']);
        $this->getInputSource()->replace($data);
        return parent::getValidatorInstance();
    }
}
