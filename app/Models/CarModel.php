<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    use HasFactory;

    protected $perPage = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'brand_id',
        'description',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeSearch($query, $request) : Builder
    {
        return $query->when($request->search, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%')
            ->orWhere('description', 'like', '%' . $request->search . '%');
        });
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
