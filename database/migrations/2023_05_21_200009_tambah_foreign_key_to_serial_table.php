<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TambahForeignKeyToSerialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('serial', function (Blueprint $table) {
            $table->unsignedInteger('id_product')->change();
            $table->foreign('id_product')
                  ->references('id_product')
                  ->on('product')
                  ->onUpdate('restrict')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('serial', function (Blueprint $table) {
            $table->integer('id_product')->change();
            $table->dropForeign('serial_id_product_foreign');
        });
    }
}
