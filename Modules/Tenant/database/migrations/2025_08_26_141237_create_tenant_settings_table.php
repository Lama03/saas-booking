<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tenant_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');

            // Branding
            $table->string('logo')->nullable();
            $table->string('header_image')->nullable();

            $table->string('primary_color')->default('#2D9CDB');
            $table->string('secondary_color')->nullable();
            $table->string('favicon')->nullable();

            // Page settings
            $table->string('page_title')->nullable();
            $table->text('page_description')->nullable();

            $table->integer('booked_today')->nullable();
            $table->integer('service_providers')->nullable();
            $table->integer('average_booking_time')->nullable();


            $table->string('footer_email')->nullable();
            $table->string('footer_phone')->nullable();
            $table->string('footer_location')->nullable();
            $table->string('footer_av_time')->nullable();



            $table->text('footer_text')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_settings');
    }
};
