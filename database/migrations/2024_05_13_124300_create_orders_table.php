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
		Schema::create('orders', function (Blueprint $table) {
			$table->id();
			$table->string("type");
			$table->text("note")->nullable();
			$table->string("client_name")->nullable();
			$table->string("phone")->nullable();
			$table->double("price");
			$table->float("discount")->default(0);
			$table->string("discount_type")->nullable();
			$table->double("total_price");
			$table->float("delivery_price")->default(0);
			$table->text("delivery_place")->nullable();
			$table->date("delivery_date")->nullable();
			$table->string("status")->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('orders');
	}
};
