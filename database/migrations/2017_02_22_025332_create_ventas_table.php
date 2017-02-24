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
			$table->biginteger('id')->unique();
			$table->string('products', 255);
			$table->integer('user_id');
			$table->string('price', 255);
			$table->string('telephone', 255);
			$table->string('adress', 255);
			$table->string('amount', 255);
            $table->mediumText('notes', 255);
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
