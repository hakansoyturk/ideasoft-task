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
        Schema::create('discount_lines', function (Blueprint $table) {
            $table->id();
            $table->integer("fk_discount_id", false, true);
            $table->integer("fk_order_id", false, true);
            $table->integer("fk_discount_category_id", false, true);
            $table->string("discount_reason");
            $table->double("discount_amount", null, null, true);
            $table->double("subtotal", null, null, true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_lines');
    }
};
