<?php

namespace App\Http\Requests\Dashboard\SubcategoryTag;

use Illuminate\Foundation\Http\FormRequest;

class SubcategoryTagUpdate extends FormRequest
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
            'name_ar' => 'required',
            'name_en' => 'required',
        ];
    }
}
