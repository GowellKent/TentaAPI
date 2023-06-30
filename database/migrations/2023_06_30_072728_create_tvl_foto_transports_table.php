<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTvlFotoTransportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvl_foto_transports', function (Blueprint $table) {
            $table->id('tft_kode');
            $table->bigInteger("tft_tt_kode")->unsigned()->nullable();
            $table->string('tft_path');
            $table->timestamps();
            $table->foreign("tft_tt_kode")->references("tt_kode")->on("tvl_transports")->onDelete("SET NULL");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tvl_foto_transports');
        
        Schema::table('tvl_foto_transports', function (Blueprint $table) {
            //
             // 1. Drop foreign key constraints
           $table->dropForeign(['tft_tt_kode']);

           // 2. Drop the column
           $table->dropColumn('tft_tt_kode');
        });
    }
}
