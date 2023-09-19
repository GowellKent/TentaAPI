<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTvlReservasiHeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvl_reservasi_heads', function (Blueprint $table) {
            $table->id('trh_kode');
            $table->bigInteger('trh_tph_kode')->unsigned()->nullable();
            $table->bigInteger('trh_tsr_kode')->unsigned()->nullable();
            $table->bigInteger('trh_tu_kode')->unsigned()->nullable();
            $table->date('trh_tgl_reservasi');
            $table->date('trh_tgl_jalan');
            $table->integer('trh_durasi');
            $table->integer('trh_pax');
            $table->integer('trh_harga');
            $table->bigInteger('trh_tp_kode_asal')->unsigned()->nullable();
            $table->bigInteger('trh_tk_kode_asal')->unsigned()->nullable();
            $table->bigInteger('trh_tp_kode_tujuan')->unsigned()->nullable();
            $table->bigInteger('trh_tk_kode_tujuan')->unsigned()->nullable();
            $table->bigInteger('trh_tt_kode')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('trh_tph_kode')->references('tph_kode')->on('tvl_paket_heads')->onDelete('SET NULL');
            $table->foreign('trh_tsr_kode')->references('tsr_kode')->on('tvl_status_reservasis')->onDelete('SET NULL');
            $table->foreign('trh_tu_kode')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('trh_tt_kode')->references('tt_kode')->on('tvl_transports')->onDelete('SET NULL');
            
            $table->foreign('trh_tp_kode_asal')->references('tp_kode')->on('tvl_provinsis')->onDelete("SET NULL");
            $table->foreign('trh_tk_kode_asal')->references('tk_kode')->on('tvl_kotas')->onDelete("SET NULL");
            $table->foreign('trh_tp_kode_tujuan')->references('tp_kode')->on('tvl_provinsis')->onDelete("SET NULL");
            $table->foreign('trh_tk_kode_tujuan')->references('tk_kode')->on('tvl_kotas')->onDelete("SET NULL");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tvl_reservasi_heads');

        Schema::table('tvl_reservasi_heads', function (Blueprint $table) {
            //
             // 1. Drop foreign key constraints
           $table->dropForeign(['trh_tph_kode']);
           $table->dropForeign(['trh_tsr_kode']);
           $table->dropForeign(['trh_tu_kode']);
           $table->dropForeign(['trh_tt_kode']);
           $table->dropForeign(['trh_tp_kode_asal']);
           $table->dropForeign(['trh_tk_kode_asal']);
           $table->dropForeign(['trh_tp_kode_tujuan']);
           $table->dropForeign(['trh_tk_kode_tujuan']);

           // 2. Drop the column
           $table->dropColumn('trh_tph_kode');
           $table->dropColumn('trh_tsr_kode');
           $table->dropColumn('trh_tu_kode');
           $table->dropColumn('trh_tt_kode');
           $table->dropColumn('trh_tp_kode_asal');
           $table->dropColumn('trh_tk_kode_asal');
           $table->dropColumn('trh_tp_kode_tujuan');
           $table->dropColumn('trh_tk_kode_tujuan');
        });
    }
}
