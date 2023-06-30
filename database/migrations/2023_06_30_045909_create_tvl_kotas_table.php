<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTvlKotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvl_kotas', function (Blueprint $table) {
            $table->id('tk_kode');
            $table->bigInteger("tk_tp_kode")->unsigned()->nullable();
            $table->string('tk_nama');
            $table->timestamps();
            $table->foreign("tk_tp_kode")->references("tp_kode")->on("tvl_provinsis")->onDelete("SET NULL");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tvl_kotas');

        Schema::table('tvl_kotas', function (Blueprint $table) {
            //
             // 1. Drop foreign key constraints
           $table->dropForeign(['tk_tp_kode']);

           // 2. Drop the column
           $table->dropColumn('tk_tp_kode');
        });
    }
}
