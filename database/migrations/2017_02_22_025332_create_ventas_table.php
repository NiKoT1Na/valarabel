<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ventas', function (Blueprint $table) {
			$table->integer('id')->unique();
			$table->string('products');
			$table->tinyinteger('user_id');
			$table->smallinteger('price');
			$table->tinyinteger('telephone');
			$table->string('adress');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('ventas');
	}
}
