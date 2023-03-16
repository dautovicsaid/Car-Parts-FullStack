<?php

namespace App\Http\Requests;

use App\Rules\ProductNameRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
        $currentYear = date('Y');
        return [
            // Unique name for product in model, category, min_applicable_year, max_applicable_year
            'name' => ['required', 'string', 'max:255', new ProductNameRule],
            'description' => ['required', 'string', 'max:500'],
            'price' => ['required', 'numeric', 'min:1'],
            'min_applicable_year' => ['required', 'integer', 'min:1900', 'max:'.$currentYear],
            'max_applicable_year' => ['required', 'integer', 'min:1900', 'max:'.$currentYear],
            'category_id' => ['required', 'integer', 'exists:product_categories,id'],
            'model_id' => ['required', 'integer', 'exists:car_models,id'],
            'brand_id' => ['required', 'integer', 'exists:brands,id'],
            'image' => ['required', 'image', 'max:2048'],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated();
        unset($data['image']);
        unset($data['brand_id']);
        return $data;
    }
}
