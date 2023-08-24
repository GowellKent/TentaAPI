<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTvlReservasiDetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvl_reservasi_dets', function (Blueprint $table) {
            $table->id('trd_kode');
            $table->bigInteger('trd_trh_kode')->unsigned()->nullable();
            $table->bigInteger('trd_tot_kode')->unsigned()->nullable();
            $table->integer('trd_hari');
            $table->time('trd_jam');
            $table->timestamps();

            $table->foreign('trd_trh_kode')->references('trh_kode')->on('tvl_reservasi_heads')->onDelete('CASCADE');
            $table->foreign('trd_tot_kode')->references('tot_kode')->on('tvl_objek_tujuans')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tvl_reservasi_dets');

        Schema::table('tvl_reservasi_dets', function (Blueprint $table) {
            //
             // 1. Drop foreign key constraints
           $table->dropForeign(['trd_trh_kode']);
           $table->dropForeign(['trd_tot_kode']);

           // 2. Drop the column
           $table->dropColumn('trd_trh_kode');
           $table->dropColumn('trd_tot_kode');
        });
    }
}
