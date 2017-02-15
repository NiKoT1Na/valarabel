<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prod', function (Blueprint $table) {

            $table->increments('id');
            $table->string('user_id', 255);
            $table->string('name', 255);
            $table->string('file', 255);
            $table->longtext('details');
            $table->integer('price');
            $table->integer('category_id');
            $table->integer('inv');
            $table->timestamps();

        });
        //artisan migrate

        // Schema::table('prod', function($table) {
        //     $table->string('disclaimer', 255);
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists('prod');
        // seeds datos de mentiras para llenar las tablas 
        //  

        // Schema::table('prod', function($table) {
        //     $table->dropColumn('disclaimer');
        // });
    }
}
