<?php

namespace App\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ProductNameRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $product = Product::query()->where('name', $value)
            ->where('model_id', request()->model_id)
            ->where('category_id', request()->category_id)
            ->when(request()->product, fn($query) => $query->where('id', '!=', request()->product->id))
            ->where('min_applicable_year', request()->min_applicable_year)
            ->where('max_applicable_year', request()->max_applicable_year)
            ->exists()
        && $fail('The :attribute is already taken for product with same category, model, min year and max year.');
    }
}
