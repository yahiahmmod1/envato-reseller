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
        Schema::create('support_infos', function (Blueprint $table) {
            $table->id();
            $table->string('whatsapp_id')->nullable();
            $table->string('telegram_id')->nullable();
            $table->string('phone_contact')->nullable();
            $table->string('email_contact')->nullable();
            $table->string('site_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_infos');
    }
};
