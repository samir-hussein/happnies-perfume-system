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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("order_id")->unsigned();
            $table->string("name");
            $table->string("code");
            $table->double("qty");
            $table->double("unit_price");
            $table->double("price");
            $table->float("discount")->default(0);
            $table->string("discount_type")->nullable();
            $table->double("total_price");
            $table->foreign("order_id")->on("orders")->references("id")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
