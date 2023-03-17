<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $perPage = 10;
    protected $fillable = [
        'name',
        'price',
        'description',
        'min_applicable_year',
        'max_applicable_year',
        'model_id',
        'category_id',
    ];

    public function carModel()
    {
        return $this->belongsTo(CarModel::class, 'model_id');
    }

    public function brand()
    {
        return $this->hasOneThrough(Brand::class, CarModel::class, 'id', 'id', 'model_id', 'brand_id');
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function scopeSearch($query, $request) : Builder
    {
        return $query->when($request->search, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        });
    }
}
