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
        Schema::create('discount_categories', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->enum("type", ["percentage", "free"]); // Oran veya 5 alana 1 bedava
            $table->string("amount"); // 10%, -1
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_categories');
    }
};
