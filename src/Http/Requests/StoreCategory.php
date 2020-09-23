<?php

namespace ManaCMS\ManaCategories\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreCategory extends FormRequest
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
        if ($this->get('_method') == 'PATCH') {
            return [
                'title' => 'required|string|max:191',
                'slug' => 'required|string|max:100|unique:categories,slug,'.$this->get('old_category_id'),
                'description' => 'required|string',
                'parent' => 'required',
            ];
        }
        return [
            'title' => 'required|string|max:191',
            'slug' => 'required|unique:categories|string|max:100',
            'description' => 'required|string',
            'parent' => 'required',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->get('slug') == null) {
            $this->merge(['slug'=>str_replace([' ',',','.'],['-'],$this->get('title'))]);
        }
    }
}
