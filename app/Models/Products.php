<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'code',
        'quantity',
        'price',
        'status',
        'status',
        'verified',
        'referral_code',
        'created_at',
        'updated_at',
    ];

    protected $attributes = [
        'updated_at' => null,
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function productInfo() {
        return $this->hasOne(ProductInfo::class, 'product_id', 'product_id')->withDefault();
    }
}
