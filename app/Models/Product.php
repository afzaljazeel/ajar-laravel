<?php

namespace App\Models;
use HasFactory;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $casts = [
        'sizes' => 'array',
        'variants' => 'array',
        'status' => 'boolean',
    ];
    //define table name
    protected $fillable = [
        'name', 'category_id', 'price', 'sale_price',
        'sizes', 'variants', 'description', 'image','status'
    ];

    //define relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function images()
    {
        return $this->hasMany(\App\Models\ProductImage::class);
    }

    public function coverImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_cover', true);
    }


}
