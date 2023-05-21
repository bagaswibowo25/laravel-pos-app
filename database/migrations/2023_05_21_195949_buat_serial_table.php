<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BuatSerialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serial', function (Blueprint $table) {
            $table->increments('id_serial');
            $table->integer('id_product');
            $table->string('nomor_seri')->unique();
            $table->date('warranty_start')->nullable();
            $table->integer('warranty_year')->nullable();
            $table->integer('used');
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
        Schema::dropIfExists('serial');
    }
}
