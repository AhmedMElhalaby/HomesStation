<?php

namespace App\Http\Requests\Dashboard\Subcategory;

use Illuminate\Foundation\Http\FormRequest;

class SubcategoryStore extends FormRequest
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
            'category_id' => 'required|exists:categories,id',
            'name_ar' => 'required',
            'name_en' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif',
        ];
    }
}
