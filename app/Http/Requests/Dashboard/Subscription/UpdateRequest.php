<?php

namespace App\Http\Requests\Dashboard\Subscription;

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
            'name_ar' => 'required',
            'name_en' => 'required',
            'user_type' => 'required|in:providers,delegates',
            'period' => 'required|numeric|min:1',
            'period_type' => 'required|in:hours,days,weeks,months,years',
            'price' => 'required|numeric',
        ];
    }
}
