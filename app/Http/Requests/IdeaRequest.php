<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IdeaRequest extends FormRequest
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
            'name'  => 'required|max:50',
            'email' => 'required|email',
            'idea'  => 'required|max:500'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'  => 'Name field is required.',
            'name.max'       => 'Name field max charecter limit is 50.',
            'email.required' => 'Email field is required.',
            'email.max'      => 'Please enter a valid email address.',
            'idea.required'  => 'Idea field is required.',
            'idea.max'       => 'Idea field max charecter limit is 500.'
        ];
    }
}
