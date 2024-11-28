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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->text('slogan')->nullable();
            $table->string('image')->nullable();
            $table->text('url')->nullable();
            $table->text('btn1_name')->nullable();
            $table->text('btn2_name')->nullable();
            $table->text('custom_field_1')->nullable();
            $table->text('custom_field_2')->nullable();
            $table->text('custom_field_3')->nullable();
            $table->integer('order_number')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
