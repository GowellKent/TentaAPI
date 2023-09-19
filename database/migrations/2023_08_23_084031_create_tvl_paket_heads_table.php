<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTvlPaketHeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvl_paket_heads', function (Blueprint $table) {
            $table->id("tph_kode");
            $table->string('tph_nama');
            $table->bigInteger('tph_tjt_kode')->unsigned()->nullable();
            $table->integer('tph_durasi');
            $table->bigInteger('tph_tp_kode_asal')->unsigned()->nullable();
            $table->bigInteger('tph_tk_kode_asal')->unsigned()->nullable();
            $table->bigInteger('tph_tp_kode_tujuan')->unsigned()->nullable();
            $table->bigInteger('tph_tk_kode_tujuan')->unsigned()->nullable();
            $table->integer('tph_harga');
            $table->timestamps();

            $table->foreign('tph_tjt_kode')->references('tjt_kode')->on('tvl_jenis_trips')->onDelete("SET NULL");
            $table->foreign('tph_tp_kode_asal')->references('tp_kode')->on('tvl_provinsis')->onDelete("SET NULL");
            $table->foreign('tph_tk_kode_asal')->references('tk_kode')->on('tvl_kotas')->onDelete("SET NULL");
            $table->foreign('tph_tp_kode_tujuan')->references('tp_kode')->on('tvl_provinsis')->onDelete("SET NULL");
            $table->foreign('tph_tk_kode_tujuan')->references('tk_kode')->on('tvl_kotas')->onDelete("SET NULL");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tvl_paket_heads');

        Schema::table('tvl_paket_heads', function (Blueprint $table) {
            //
             // 1. Drop foreign key constraints
           $table->dropForeign(['tph_tjt_kode']);
           $table->dropForeign(['tph_tp_kode_asal']);
           $table->dropForeign(['tph_tk_kode_asal']);
           $table->dropForeign(['tph_tp_kode_tujuan']);
           $table->dropForeign(['tph_tk_kode_tujuan']);

           // 2. Drop the column
           $table->dropColumn('tph_tjt_kode');
           $table->dropColumn('tph_tp_kode_asal');
           $table->dropColumn('tph_tk_kode_asal');
           $table->dropColumn('tph_tp_kode_tujuan');
           $table->dropColumn('tph_tk_kode_tujuan');
        });
    }
}
