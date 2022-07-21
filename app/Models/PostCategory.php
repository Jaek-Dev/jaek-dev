<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'author_id',
        'type',
        'name',
        'slug',
        'created_at',
        'updated_at',
    ];
}
