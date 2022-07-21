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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 60)->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', [
                'editor',
                'admin',
            ])->default('editor');
            $table->enum('status', [
                'active',
                'disabled',
                'deleted',
                'blocked',
            ])->default('active');
            $table->boolean('verified')->default(false);
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('last_login')->nullable();
            $table->dateTime('last_seen')->nullable();
            $table->comment('For saving the basic authentication information of users.');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
