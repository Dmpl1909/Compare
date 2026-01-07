<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('source_id')->constrained()->cascadeOnDelete();
            $table->decimal('price', 10, 2);
            $table->string('availability')->nullable();
            $table->string('url');
            $table->timestamp('collected_at')->nullable();
            $table->timestamps();
            $table->unique(['product_id', 'source_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
