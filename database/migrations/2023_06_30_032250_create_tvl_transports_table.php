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
            $table->string('tt_provinsi_asal');
            $table->string('tt_kota_asal');
            $table->string('tt_provinsi_tujuan');
            $table->string('tt_kota_tujuan');
            $table->integer('tt_pax');
            $table->integer('tt_harga');
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
        Schema::dropIfExists('tvl_transports');
    }
}
