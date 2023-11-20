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
        Schema::create('pertes', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->foreignId('product_Article_id')->constrained();
            $table->foreignId('category_id')->constrained();
            $table->integer('unitPrice');
            $table->integer('totalPrice');
            $table->integer('quantity');
            $table->foreignId('typeperte_id')->constrained();
            $table->string('Description');
            $table->string('status')->default('0');
            $table->foreignId('user_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertes');
    }
};
