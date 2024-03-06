<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('phone_no')->unique();
            $table->string('password');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('address');
            $table->string('created_date');
            $table->string('updated_date');
            $table->integer('status');
            $table->integer('role_id');
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
