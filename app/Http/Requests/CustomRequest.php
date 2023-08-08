<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'author_name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'category_name' => 'required|array',
        ];
    }

    public function messages(): array{
        return [
            'title.required' => 'The title field is required.',
            'author_name.required' => 'The author name field is required.',
            'description.required' => 'The description field is required.',
            'price.required' => 'The price field is required.',
            'price.numeric' => 'The price must be a numeric value.',
            'category_name.required' => 'At least one category must be selected.',
           
        ];
    }
}
