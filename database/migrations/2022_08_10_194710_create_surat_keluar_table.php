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
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_surat');
            $table->string('perihal_surat', 100)->nullable();
            $table->string('nomor_surat', 100)->nullable();
            $table->string('judul_surat', 100)->nullable();
            $table->string('link_surat', 200);
            $table->unsignedBigInteger('pettd');
            $table->unsignedTinyInteger('is_ttd')->nullable();
            $table->dateTime('ttd_date')->nullable();
            $table->unsignedBigInteger('pemaraf1');
            $table->unsignedTinyInteger('is_paraf1')->nullable();
            $table->dateTime('paraf1_date')->nullable();
            $table->unsignedBigInteger('pemaraf2')->nullable();
            $table->unsignedTinyInteger('is_paraf2')->nullable();
            $table->dateTime('paraf2_date')->nullable();
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
        Schema::dropIfExists('surat_keluar');
    }
};
