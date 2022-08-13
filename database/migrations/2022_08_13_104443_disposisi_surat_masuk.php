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
        Schema::create('disposisi_surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->integer('id_surat')->nullable()->length(20)->unsigned();
            $table->unsignedBigInteger('source_disposisi');
            $table->unsignedBigInteger('target_disposisi');
            $table->date('tanggal_disposisi');
            $table->integer('no_disposisi')->nullable()->length(1)->unsigned();
            $table->integer('is_last_disposisi')->nullable()->length(1)->unsigned();
            $table->integer('is_selesai')->nullable()->length(1)->unsigned();
            $table->unsignedBigInteger('created_by');
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