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
        Schema::create('kegiatan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('desa_wisata_id')->unsigned();
            $table->bigInteger('kategori_id')->unsigned();
            $table->string('nama_kegiatan');
            $table->text('deskripsi');
            $table->string('foto');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('desa_wisata_id')->references('id')->on('desa_wisata');
            $table->foreign('kategori_id')->references('id')->on('kategori');
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
