<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInfo extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $primaryKey = 'product_id';
    public $incrementing = false;
    public $table = 'product_info';
}
