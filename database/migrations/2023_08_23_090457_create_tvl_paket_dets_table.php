<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTvlPaketDetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvl_paket_dets', function (Blueprint $table) {
            $table->id('tpd_kode');
            $table->bigInteger('tpd_tph_kode')->unsigned()->nullable();
            $table->bigInteger('tpd_tot_kode')->unsigned()->nullable();
            $table->integer('tpd_hari');
            $table->time('tpd_jam');
            $table->foreign('tpd_tph_kode')->references('tph_kode')->on('tvl_paket_heads')->onDelete('CASCADE');
            $table->foreign('tpd_tot_kode')->references('tot_kode')->on('tvl_objek_tujuans')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tvl_paket_dets');

        Schema::table('tvl_paket_dets', function (Blueprint $table) {
            //
             // 1. Drop foreign key constraints
           $table->dropForeign(['tpd_tph_kode']);
           $table->dropForeign(['tpd_tot_kode']);

           // 2. Drop the column
           $table->dropColumn('tpd_tph_kode');
           $table->dropColumn('tpd_tot_kode');
        });
    }
}
