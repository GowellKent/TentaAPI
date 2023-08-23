<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTvlFotoObjeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvl_foto_objeks', function (Blueprint $table) {
            $table->id('tfo_kode');
            $table->bigInteger("tfo_tot_kode")->unsigned()->nullable();
            $table->string('tfo_path');
            $table->timestamps();
            $table->foreign("tfo_tot_kode")->references("tot_kode")->on("tvl_objek_tujuans")->onDelete("SET NULL");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tvl_foto_objeks');

        Schema::table('tvl_foto_objeks', function (Blueprint $table) {
            //
             // 1. Drop foreign key constraints
           $table->dropForeign(['tfo_tot_kode']);

           // 2. Drop the column
           $table->dropColumn('tfo_tot_kode');
        });
    }
}
