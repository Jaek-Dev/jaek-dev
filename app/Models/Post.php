<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    //Disable timestamps
    public $timestamps = false;

    protected $fillable = [
        'category_id',
        'author_id',
        'type',
        'title',
        'slug',
        'content',
        'photo',
        'views',
        'tags',
        'source_code_url',
        'preview_url',
        'created_at',
        'updated_at',
    ];

    public function post($parent_slug, $slug) {
        $post = $this->where('slug', $slug)->firstOrFail();
        if(!$post->category->id) \abort(404);
        // $post->comments()->paginate(10);
        return $post;
    }

    public function category() {
        return $this->belongsTo(PostCategory::class);
    }

    public function comments() {
        return $this->hasMany(PostComment::class);
    }
}
