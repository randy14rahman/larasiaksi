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
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_surat');
            $table->string('asal_surat', 100)->nullable();
            $table->string('perihal_surat', 100)->nullable();
            $table->string('nomor_surat', 100)->nullable();
            $table->integer('jenis_surat_masuk')->nullable()->length(1)->unsigned();
            $table->unsignedBigInteger('id_operator');
            $table->string('link_file', 100)->nullable();
            $table->integer('assign_to')->nullable()->length(1)->unsigned();
            $table->integer('is_disposisi')->nullable()->length(1)->unsigned();
            $table->integer('is_proses')->nullable()->length(1)->unsigned();
            $table->integer('is_arsip')->nullable()->length(1)->unsigned();
            $table->integer('is_deleted')->nullable()->length(1)->unsigned();
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