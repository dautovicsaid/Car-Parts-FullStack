<?php

namespace App\Http\Resources;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarModelResource extends JsonResource
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
            'brand' => $this->whenLoaded('brand', fn() => $this->brand->name),
            'image' => $this->image ? ImageResource::make($this->image) : ['path' => config('app.url').'/'.Image::PLACEHOLDER],
            'brand_id' => $this->whenLoaded('brand', fn() => $this->brand->id),
        ];
    }
}
