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
        Schema::create('download_lists', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('item_id');
            $table->string('site_id');
            $table->string('content_link');
            $table->integer('cookie_id')->nullable();
            $table->string('download_url');
            $table->string('download_url_updated');
            $table->enum('status',['pending','success','failed']);
            $table->enum('download_type',['cookie','api']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('download_lists');
    }
};
