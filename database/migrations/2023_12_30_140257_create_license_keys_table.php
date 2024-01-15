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
        Schema::create('license_keys', function (Blueprint $table) {
            $table->id();
            $table->integer('site_id');
            $table->string('license_key');
            $table->bigInteger('user_id')->nullable();
            $table->string('used_date')->nullable();;
            $table->string('expiry_date')->nullable();
            $table->integer('days_limit');
            $table->integer('daily_limit');
            $table->integer('total_limit');
            $table->enum('status',['new','sold','used','expired'])->default('new');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('license_keys');
    }
};
