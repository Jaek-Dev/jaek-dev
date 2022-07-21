<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'post_id',
        'author',
        'email',
        'website',
        'comment',
        'created_at',
        'updated_at',
    ];
}
