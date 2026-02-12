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
    Schema::create('businesses', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('name');
        $table->string('slug')->unique();
        $table->enum('type', [
            'hotel',
            'cabaña',
            'hostal',
            'restaurante',
            'cafeteria',
            'otro'
        ]);
        $table->text('description')->nullable();
        $table->decimal('price_from', 10, 2)->nullable();
        $table->boolean('is_active')->default(false); // admin aprueba
        $table->json('images')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
