<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ProductReview;

class Product extends Model
{
   protected $fillable = [
    'user_id',
    'name',
    'description',
    'category',
    'price',
    'quantity',
    'image',
    'harvest_date',
    'expiration_date'
];

    public function farmer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }
}