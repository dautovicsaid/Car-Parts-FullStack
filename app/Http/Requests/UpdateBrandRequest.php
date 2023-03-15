<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBrandRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'string|max:500',
            'image' => 'nullable|image|max:2048',
        ];
    }

    public function validated($key = null, $default = null)
    {
        $validated = parent::validated();
        if (array_key_exists('image', $validated)) unset($validated['image']);
        return $validated;
    }
}
