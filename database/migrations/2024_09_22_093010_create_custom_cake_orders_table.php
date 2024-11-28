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
        Schema::create('custom_cake_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('custom_cake_id')->constrained('custom_cakes')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('custom_cake_customer_id')->constrained('custom_cake_customers')->onDelete('cascade');
            $table->foreignId('custom_cake_flavor_id')->constrained('custom_cake_flavors')->onDelete('cascade');
            $table->text('photo_on_cake')->nullable();
            $table->text('message_on_cake')->nullable();
            $table->string('weight'); // Adjust the precision as necessary
            $table->string('delivery_location')->nullable();
            $table->string('delivery_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_cake_orders');
    }
};
