<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTempatWisatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tempat_wisata', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('desa_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->string('nama_wisata');
            $table->string('alamat_wisata');
            $table->text('sejarah_wisata');
            $table->text('demografi');
            $table->text('potensi');
            $table->text('lat');
            $table->text('lng');
            $table->timestamps();

            $table->foreign('desa_id')->references('id')->on('desa');
            $table->foreign('user_id')->references('id')->on('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tempat_wisata');
    }
}
