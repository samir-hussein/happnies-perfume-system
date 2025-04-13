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
        Schema::create('gather_items', function (Blueprint $table) {
            $table->id();
            $table->string("gather_id");
            $table->string("code");
            $table->string("name");
            $table->double("price");
            $table->double("qty");
            $table->bigInteger("order_id")->unsigned();
            $table->foreign("order_id")->on("orders")->references("id")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gather_items');
    }
};
