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
            $table->string('tph_provinsi_asal');
            $table->string('tph_kota_asal');
            $table->string('tph_provinsi_tujuan');
            $table->string('tph_kota_tujuan');
            $table->integer('tph_harga');
            $table->timestamps();
            $table->foreign('tph_tjt_kode')->references('tjt_kode')->on('tvl_jenis_trips')->onDelete("SET NULL");
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

           // 2. Drop the column
           $table->dropColumn('tph_tjt_kode');
        });
    }
}
