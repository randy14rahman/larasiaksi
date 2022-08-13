<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proses_surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->integer('id_surat')->nullable()->length(10)->unsigned();
            $table->date('tanggal_proses');
            $table->integer('id_pemroses')->nullable()->length(20)->unsigned();
            $table->unsignedTinyInteger('is_selesai')->nullable();
            $table->date('tanggal_selesai');
            $table->unsignedBigInteger('created_by');
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
        //
    }
};