<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained('businesses')->onDelete('cascade');
            $table->string('type')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price_low', 10, 2)->nullable();
            $table->decimal('price_high', 10, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->json('images')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('items');
    }
};
