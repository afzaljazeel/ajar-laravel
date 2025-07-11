<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //create a cart entry using Cart::create([...]).
    protected $fillable = [
        'user_id',
        'product_id',
        'size',
        'variant',
        'quantity',
    ];
    //defining relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
