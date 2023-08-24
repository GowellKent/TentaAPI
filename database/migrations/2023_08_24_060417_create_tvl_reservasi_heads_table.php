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
            $table->string('trh_provinsi_asal');
            $table->string('trh_kota_asal');
            $table->string('trh_provinsi_tujuan');
            $table->string('trh_kota_tujuan');
            $table->bigInteger('trh_tt_kode')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('trh_tph_kode')->references('tph_kode')->on('tvl_paket_heads')->onDelete('SET NULL');
            $table->foreign('trh_tsr_kode')->references('tsr_kode')->on('tvl_status_reservasis')->onDelete('SET NULL');
            $table->foreign('trh_tu_kode')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('trh_tt_kode')->references('tt_kode')->on('tvl_transports')->onDelete('SET NULL');
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

           // 2. Drop the column
           $table->dropColumn('trh_tph_kode');
           $table->dropColumn('trh_tsr_kode');
           $table->dropColumn('trh_tu_kode');
           $table->dropColumn('trh_tt_kode');
        });
    }
}
