<?php

namespace App\Http\Requests\Api\Service;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'subcategory_id' => 'required|exists:subcategories,id',
            'subcategory_tag_id' => 'nullable|exists:subcategory_tags,id',
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'images' => 'nullable',
            'images.*' => 'mimes:jpeg,jpg,png,gif',
            'additions' => 'nullable',
            'lat' => 'nullable',
            'lng' => 'nullable',
            'far_enough' => 'nullable',
            'execution_time' => 'nullable',
            'availability' => 'nullable',
            'provider_mobile' => 'nullable',
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
}
