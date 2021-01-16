<?php

namespace App\Http\Requests\Api\Provider;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProviderDataRequest extends FormRequest
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
            'username' => 'nullable|unique:users,username,' . $this->user()->id,
            'email' => 'nullable|email|unique:users,email,' . $this->user()->id,
            'fullname' => 'nullable',
            'mobile' => 'nullable|numeric|min:10|unique:users,mobile,' . $this->user()->id,
            'avatar' => 'nullable|mimes:jpeg,jpg,png,gif',
            'lat' => 'nullable',
            'lng' => 'nullable',
            'city_id' => 'nullable|exists:cities,id',
            'nationality_id' => 'nullable|exists:nationalities,id',
            'commercial_register_number' => 'nullable|unique:providers,commercial_register_number,' . $this->user()->ProviderData->id,
            'commercial_register_image' => 'nullable|mimes:jpeg,jpg,png,gif',
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
