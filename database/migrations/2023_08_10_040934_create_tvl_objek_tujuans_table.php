<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTvlObjekTujuansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvl_objek_tujuans', function (Blueprint $table) {
            $table->id('tot_kode');
            $table->string('tot_nama');
            $table->string('tot_telp');
            $table->string('tot_alamat');
            $table->bigInteger('tot_tjo_kode')->unsigned()->nullable();
            $table->foreign('tot_tjo_kode')->references('tjo_kode')->on('tvl_jenis_objeks')->onDelete('SET NULL');
            $table->bigInteger('tot_tp_kode')->unsigned()->nullable();
            $table->foreign('tot_tp_kode')->references('tp_kode')->on('tvl_provinsis')->onDelete('SET NULL');
            $table->bigInteger('tot_tk_kode')->unsigned()->nullable();
            $table->foreign('tot_tk_kode')->references('tk_kode')->on('tvl_kotas')->onDelete('SET NULL');
            $table->integer('tot_harga');
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
        Schema::dropIfExists('tvl_objek_tujuans');

        Schema::table('tvl_objek_tujuans', function (Blueprint $table) {
            //
             // 1. Drop foreign key constraints
           $table->dropForeign(['tot_tjo_kode']);
           $table->dropForeign(['tot_tp_kode']);
           $table->dropForeign(['tot_tk_kode']);

           // 2. Drop the column
           $table->dropColumn('tot_tjp_kode');
           $table->dropColumn('tot_tp_kode');
           $table->dropColumn('tot_tk_kode');
        });
    }
}
