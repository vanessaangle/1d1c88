<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKegiatansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atraksi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('desa_wisata_id')->unsigned();
            $table->string('nama_atraksi');
            $table->text('deskripsi');
            $table->string('foto');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('desa_wisata_id')->references('id')->on('desa_wisata');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('atraksi');
    }
}
