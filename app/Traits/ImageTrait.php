<?php

namespace App\Traits;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;

trait ImageTrait
{

    /**
     * @param $image
     * @param $imageable_id
     * @param $imageable_type
     * @param $type
     * @return void
     */
    public function storeImage($image, $imageable_id, $dir, $imageable_type, $type = null): void
    {
        $tmp = $image->store('public/uploads/images/' . $dir);
        $image_path = 'storage/' . str_replace('public/', '', $tmp);
        Image::query()->create([
            'name' => $image->getClientOriginalName(),
            'path' => $image_path,
            'imageable_id' => $imageable_id,
            'imageable_type' => $imageable_type,
            'type' => $type,
        ]);
    }

    /**
     * @param $model
     * @return void
     */
    public function deleteImage($model): void
    {
        $image = $model->image;
        $image_delete = str_replace('storage/', 'public/', $image->path);
        Storage::delete($image_delete);
        $model->image()->delete();
    }


}
