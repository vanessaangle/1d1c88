<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAtraksiFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atraksi_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('atraksi_id')->unsigned();
            $table->string('tipe');
            $table->text('file');
            $table->string('judul')->nullable();
            $table->timestamps();

            $table->foreign('atraksi_id')->references('id')->on('atraksi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('atraksi_files');
    }
}
