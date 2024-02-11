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
        Schema::create('site_cookies', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('site_id');
            $table->string('account');
            $table->string('cookie_source')->nullable();
            $table->longText('cookie_content');
            $table->text('csrf_token')->nullable();
            $table->enum('status',['active','inactive'])->nullable('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_cookies');
    }
};
