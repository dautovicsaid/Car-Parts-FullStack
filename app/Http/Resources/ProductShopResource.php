<?php

namespace App\Http\Resources;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductShopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
        'id' => $this->id,
        'name' => $this->name,
        'description' => $this->description,
        'year_from' => $this->min_applicable_year,
        'year_to' => $this->max_applicable_year,
        'price' => $this->price,
        'model' => $this->whenLoaded('carModel', fn() => $this->carModel->name),
        'image' => $this->image ? ImageResource::make($this->image) : ['path' => config('app.url').'/'.Image::PLACEHOLDER],
        'category' => $this->whenLoaded('productCategory', fn() => $this->productCategory->name),
        'brand' => $this->whenLoaded('carModel', fn() => $this->carModel->brand->name),
       ];
    }
}
