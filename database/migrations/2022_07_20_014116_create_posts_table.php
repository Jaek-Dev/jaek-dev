<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                ->nullable()
                ->constrained('post_categories')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('author_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->enum('type', ['blog', 'project'])
                ->default('blog')
                ->comment('The type of post created');
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->longText('content')->nullable();
            $table->string('photo')->nullable();
            $table->unsignedInteger('views', false)->default('0');
            $table->text('tags');
            $table->string('source_code_url')->nullable();
            $table->string('preview_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
