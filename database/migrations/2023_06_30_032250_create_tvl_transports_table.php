<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTvlTransportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvl_transports', function (Blueprint $table) {
            $table->id('tt_kode');
            $table->string('tt_nama');
            $table->bigInteger('tt_tp_kode_asal')->unsigned()->nullable();
            $table->bigInteger('tt_tk_kode_asal')->unsigned()->nullable();
            $table->bigInteger('tt_tp_kode_tujuan')->unsigned()->nullable();
            $table->bigInteger('tt_tk_kode_tujuan')->unsigned()->nullable();
            $table->integer('tt_pax');
            $table->integer('tt_harga');
            $table->timestamps();

            // $table->foreign('tt_tp_kode_asal')->references('tp_kode')->on('tvl_provinsis')->onDelete('SET NULL');
            // $table->foreign('tt_tk_kode_asal')->references('tk_kode')->on('tvl_kotas')->onDelete('SET NULL');
            // $table->foreign('tt_tp_kode_tujuan')->references('tp_kode')->on('tvl_provinsis')->onDelete('SET NULL');
            // $table->foreign('tt_tk_kode_tujuan')->references('tk_kode')->on('tvl_kotas')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tvl_transports');

        Schema::table('tvl_transports', function (Blueprint $table) {
            //
        //      // 1. Drop foreign key constraints
        //    $table->dropForeign(['tt_tp_kode_asal']);
        //    $table->dropForeign(['tt_tk_kode_asal']);
        //    $table->dropForeign(['tt_tp_kode_tujuan']);
        //    $table->dropForeign(['tt_tk_kode_tujuan']);

        //    // 2. Drop the column
        //    $table->dropColumn('tt_tp_kode_asal');
        //    $table->dropColumn('tt_tk_kode_asal');
        //    $table->dropColumn('tt_tp_kode_tujuan');
        //    $table->dropColumn('tt_tk_kode_tujuan');
        });
    }
}
